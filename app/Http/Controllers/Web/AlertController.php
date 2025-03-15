<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AlertController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $alerts = $user->storageTanks()
                    ->with([
                        'customAlerts.alerts.customAlert.storageTank',
                        'customAlerts.alerts.mq2Reading',
                        'customAlerts.alerts.bmp180Reading'
                    ])
                    ->get()
                    ->pluck('customAlerts')
                    ->flatten()
                    ->pluck('alerts')
                    ->flatten();

        return Inertia::render('Alert/Index', [
            '_alerts' => $alerts
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function resolve(Alert $alert)
    {
        $alert->status = 'resolved';
        $alert->save();

        return redirect()
                ->route('alerts.index')
                ->with('message', 'Alert resolved successfully!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
