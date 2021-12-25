<?php

namespace App\Http\Controllers;

use App\Http\Requests\Network\StoreRequest;
use App\Http\Requests\Network\UpdateRequest;
use App\Models\Network;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NetworkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        return Inertia::render('Networks/Index', [
            'networks' => function () {
                return Network::where('user_id', \Auth::user()->id)->orWhereNull('user_id')->with('ips')->orderBy('name')->get()->map(function (Network $network) {
                    return [
                        'id' => $network->id,
                        'name' => $network->name,
                        'range' => $network->range->getNetworkPortion().'/'.$network->range->getNetworkSize(),
                        'range_start' => $network->range_start,
                        'range_end' => $network->range_end,
                        'max_hosts' => $network->range->getNumberAddressableHosts(),
                        'hosts' => $network->ips()->count('id'),
                    ];
                });
            },
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('Networks/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Network\StoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $network = new Network();
        $network->user_id = \Auth::id();
        $network->name = $data['name'];
        $network->range = $data['range'];

        if ($network->save()) {
            return redirect()->route('networks.show', $network->id)->with('success', 'The network has been successfully added.');
        }

        return redirect()->back()->withErrors(['alert', 'The network could not be added.']);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Network $network
     * @return \Inertia\Response
     */
    public function show(Network $network)
    {
        $networkIps = $network->ips;
        $ips = collect($network->range->getAllHostIPAddresses())->mapWithKeys(function ($ip) use ($networkIps) {
            $networkIp = $networkIps->first(function ($value) use ($ip) {
                return $value->address == $ip;
            });

            return [
                $ip => [
                    'id' => $networkIp?->id,
                    'name' => $networkIp?->name,
                    'address' => $ip,
                    'ports' => $networkIp?->ports ?? [],
                ],
            ];
        });

        return Inertia::render('Networks/Show', [
            'network' => [
                'id' => $network->id,
                'name' => $network->name,
                'range' => $network->range->getNetworkPortion().'/'.$network->range->getNetworkSize(),
                'range_start' => $network->range_start,
                'range_end' => $network->range_end,
                'max_hosts' => $network->range->getNumberAddressableHosts(),
                'hosts' => $networkIps->count(),
                'ips' => $ips,
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Network $network
     * @return \Inertia\Response
     */
    public function edit(Network $network)
    {
        return Inertia::render('Networks/Edit', [
            'network' => [
                'id' => $network->id,
                'name' => $network->name,
                'range' => $network->range->getNetworkPortion().'/'.$network->range->getNetworkSize(),
                'range_start' => $network->range_start,
                'range_end' => $network->range_end,
                'max_hosts' => $network->range->getNumberAddressableHosts(),
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Network\UpdateRequest $request
     * @param \App\Models\Network $network
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, Network $network)
    {
        $data = $request->validated();

        $network->name = $data['name'];
        $network->range = $data['range'];

        if ($network->save()) {
            return redirect()->route('networks.show', $network->id)->with('success', 'The network was successfully updated.');
        }

        return redirect()->back()->withErrors(['alert' => 'The network could not be updated.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Network $network
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Network $network)
    {
        if ($network->delete()) {
            return redirect()->route('networks.index')->with('success', 'The network was successfully deleted.');
        }

        return redirect()->back()->withErrors(['alert' => 'The network could not be deleted.']);
    }
}
