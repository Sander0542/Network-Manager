<?php

namespace App\Http\Controllers;

use App\Models\Network;
use Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Dashboard/Index', [
            'newHosts' => Network::whereUser(Auth::id())->rightJoin('network_ips', 'networks.id', '=', 'network_ips.network_id')->orderByDesc('created_at')->limit(5)->get([
                'networks.name as network_name',
                'network_ips.network_id',
                'network_ips.name',
                'network_ips.address',
                'network_ips.created_at',
                'network_ips.updated_at',
            ]),
            'updatedHosts' => Network::whereUser(Auth::id())->rightJoin('network_ips', 'networks.id', '=', 'network_ips.network_id')->orderByDesc('updated_at')->limit(5)->get([
                'networks.name as network_name',
                'network_ips.network_id',
                'network_ips.name',
                'network_ips.address',
                'network_ips.created_at',
                'network_ips.updated_at',
            ]),
        ]);
    }
}
