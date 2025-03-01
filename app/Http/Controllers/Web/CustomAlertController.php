<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\CustomAlert;
use App\Models\StorageTank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class CustomAlertController extends Controller
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
        return Inertia::render('CustomAlert/Create', [
            'storageTank' => $storageTank
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'storage_tank_id' => 'required|exists:storage_tanks,id',
            'mq2_min' => 'required|numeric|min:200|max:10000',
            'mq2_max' => 'required|numeric|min:200|max:10000|gt:mq2_min',
            'bmp180_min' => 'required|numeric|min:30000|max:110000',
            'bmp180_max' => 'required|numeric|min:30000|max:110000|gt:bmp180_min',
            'level' => [
                'required',
                'string',
                'max:255',
                Rule::in(['danger', 'warning'])
            ],
            'description' => 'required|string|max:1000',
            'action_required' => 'required|string|max:1000',
        ]);
    
        CustomAlert::create($request->all());
    
        return redirect()
                ->route('storage-tanks.show', $request->input('storage_tank_id'))
                ->with('message', 'Custom Alert created successfully!');
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
    public function edit(CustomAlert $customAlert)
    {
        if(Auth::id() != $customAlert->storageTank->user_id){
            abort(403);
        }

        $customAlert->load('storageTank');

        return Inertia::render('CustomAlert/Edit', [
            'storageTanks' => StorageTank::all(),
            'customAlert' => $customAlert
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CustomAlert $customAlert)
    {
        if(Auth::id() != $customAlert->storageTank->user_id){
            abort(403);
        }

        $request->validate([
            'storage_tank_id' => 'required|exists:storage_tanks,id',
            'mq2_min' => 'required|numeric|min:200|max:10000',
            'mq2_max' => 'required|numeric|min:200|max:10000|gt:mq2_min',
            'bmp180_min' => 'required|numeric|min:30000|max:110000',
            'bmp180_max' => 'required|numeric|min:30000|max:110000|gt:bmp180_min',
            'level' => [
                'required',
                'string',
                'max:255',
                Rule::in(['danger', 'warning'])
            ],
            'description' => 'required|string|max:1000',
            'action_required' => 'required|string|max:1000',
        ]);

        $customAlert->update($request->all());

        return redirect()->route('storage-tanks.show', $customAlert->storageTank->id)
            ->with('message', 'Custom Alert updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomAlert $customAlert)
    {
        if(Auth::id() != $customAlert->storageTank->user_id){
            abort(403);
        }

        $customAlert->delete();

        return redirect(route('storage-tanks.show', $customAlert->storageTank->id))
                    ->with(['message' => 'Custom alert deleted successfully']);   
    }
}
