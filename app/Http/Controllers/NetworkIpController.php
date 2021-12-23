<?php

namespace App\Http\Controllers;

use App\Http\Requests\Network\Ip\StoreRequest;
use App\Models\Network;
use App\Models\NetworkIp;

class NetworkIpController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Network\Ip\StoreRequest $request
     * @param \App\Models\Network $network
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request, Network $network)
    {
        $data = $request->validated();

        $ip = NetworkIp::where('network_id', $network->id)->where('address', $data['address'])->first();

        if ($ip) {
            $ip->name = $data['name'];
            $ip->ports = $data['ports'];
        } else {
            $ip = new NetworkIp([
                'network_id' => $network->id,
                'address' => $data['address'],
                'name' => $data['name'],
                'ports' => $data['ports'],
            ]);
        }

        if ($ip->save()) {
            return redirect()->back()->with('success', 'IP information successfully modified.');
        }

        return redirect()->back()->withErrors(['networkId' => 'The IP information could not be modified.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Network $network
     * @param \App\Models\NetworkIp $networkIp
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Network $network, NetworkIp $networkIp)
    {
        if ($networkIp->delete()) {
            return redirect()->back()->with('success', 'The IP information was successfully deleted.');
        }

        return redirect()->back()->withErrors(['alert' => 'The IP information could not be deleted.']);
    }
}
