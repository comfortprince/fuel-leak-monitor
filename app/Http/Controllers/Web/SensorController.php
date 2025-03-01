<?php

namespace App\Http\Controllers\Web;

use App\Helpers\SystemHelper;
use App\Http\Controllers\Controller;
use App\Models\Sensor;
use App\Models\StorageTank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class SensorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(StorageTank $storageTank)
    {
        return Inertia::render('Sensors/Create',[
            'sensorTypes' => SystemHelper::getSensorTypes(),
            'storage_tank_id' => $storageTank->id
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sensor_type' => [
                'required',
                'string',
                'in:' . implode(',', SystemHelper::getSensorTypes())
            ],
            'identifier' => 'required|string|max:255|unique:sensors,identifier',
            'storage_tank_id' => [
                'required',
                'integer',
                Rule::in(Auth::user()->storageTanks->pluck('id')->toArray())
            ] 
        ]);

        Sensor::create($request->all());

        return redirect()
            ->route('storage-tanks.show', $request->input('storage_tank_id'))
            ->with([
                'message' => 'Successfully added a new sensor'
            ]);
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
    public function destroy(Sensor $sensor)
    {
        if(Auth::id() != $sensor->storageTank->user_id){
            abort(403);
        }

        $storageTank = $sensor->storageTank;
        $sensor->delete();

        return redirect(route('storage-tanks.show', $storageTank->id))
                    ->with(['message' => 'Sensor deleted successfully']); 
    }
}
