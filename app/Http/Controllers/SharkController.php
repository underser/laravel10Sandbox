<?php

namespace App\Http\Controllers;

use App\Http\Requests\Sharks\Create;
use App\Http\Requests\Sharks\Update;
use App\Models\Shark;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SharkController extends Controller
{
    public const SHARK_LEVELS = ['Select a Level', 'Sees Sunlight', 'Foosball Fanatic', 'Basement Dweller'];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sharks.index', [
            'sharks' => Shark::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sharks.create', [
            'levels' => self::SHARK_LEVELS
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Create $request)
    {
        $shark = Shark::query()->create($request->all());

        return redirect(route('sharks.show', ['shark' => $shark]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Shark $shark)
    {
        return view('sharks.show', [
            'shark' => $shark
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shark $shark)
    {
        return view('sharks.edit', [
            'shark' => $shark,
            'levels' => self::SHARK_LEVELS
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request, Shark $shark)
    {
        $shark->update($request->all());

        return view('sharks.show', [
            'shark' => $shark
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shark $shark)
    {
        $shark->delete();

        return redirect(route('sharks.index'));
    }
}
