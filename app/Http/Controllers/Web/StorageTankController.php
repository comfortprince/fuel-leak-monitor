<?php

namespace App\Http\Controllers\Web;

use App\Helpers\SystemHelper;
use App\Http\Controllers\Controller;
use App\Models\StorageTank;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class StorageTankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('StorageTank/Index', [
            'storageTanks' => Auth::user()->storageTanks
        ]);
    }

    public function analytics(StorageTank $storageTank) {
        if(Auth::id() != $storageTank->user_id){
            abort(403);
        }

        $storageTank->load('sensors.sensorReadings');

        if ($storageTank->sensors->count() === 0) {
            return redirect()->back()->with([
                'message' => 'No readings. Register some sensors on ' . $storageTank->identifier
            ]);
        }

        return Inertia::render('StorageTank/Analytics', [
            'storageTank' => $storageTank
        ]);
    } 

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('StorageTank/Create',[
            'fuelTypes' => SystemHelper::getFuelTypes()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'identifier' => [
                'required',
                'string',
                'max:255',
                Rule::unique('storage_tanks')
                    ->where(fn (Builder $query) => $query->where('user_id', '=', Auth::id()))
            ],
            'fuel_type' => [
                'required', 
                'string', 
                Rule::in(SystemHelper::getFuelTypes())
            ],
            'location' => 'required|string|max:255',
        ]);
    
        $storageTank = StorageTank::make($validated);
        $storageTank->user_id = Auth::id();
        $storageTank->save();

        return redirect(route('storage-tanks.index'))
                    ->with(['message' => 'Storage tank created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(StorageTank $storageTank)
    {
        if(Auth::id() != $storageTank->user_id){
            abort(403);
        }

        return Inertia::render('StorageTank/Show', [
            'storageTank' => $storageTank->load(['sensors', 'customAlerts'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StorageTank $storageTank)
    {
        if(Auth::id() != $storageTank->user_id){
            abort(403);
        }

        return Inertia::render('StorageTank/Edit', [
            'storageTank' => $storageTank,
            'fuelTypes' => SystemHelper::getFuelTypes()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StorageTank $storageTank)
    {
        if(Auth::id() != $storageTank->user_id){
            abort(403);
        }

        $validated = $request->validate([
            'identifier' => [
                'required',
                'string',
                'max:255',
                Rule::unique('storage_tanks')
                    ->where(fn (Builder $query) => $query->where('user_id', '=', Auth::id()))
                    ->ignore($storageTank->id)
            ],
            'fuel_type' => [
                'required', 
                'string', 
                Rule::in(SystemHelper::getFuelTypes())
            ],
            'location' => 'required|string|max:255',
        ]);
    
        $storageTank->identifier = $validated['identifier'];
        $storageTank->fuel_type = $validated['fuel_type'];
        $storageTank->location = $validated['location'];
        $storageTank->save();

        return redirect(route('storage-tanks.index'))
                    ->with(['message' => 'Storage tank updated successfully']);        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StorageTank $storageTank)
    {
        if(Auth::id() != $storageTank->user_id){
            abort(403);
        }

        $storageTank->delete();

        return redirect(route('storage-tanks.index'))
                    ->with(['message' => 'Storage tank deleted successfully']);   
    }
}
