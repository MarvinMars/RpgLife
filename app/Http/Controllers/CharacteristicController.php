<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCharacteristicRequest;
use App\Http\Requests\UpdateCharacteristicRequest;
use App\Models\Characteristic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CharacteristicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Characteristics/Index', ['characteristics' => Characteristic::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Characteristics/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCharacteristicRequest $request): RedirectResponse
    {
        $characteristic = auth()->user()->characteristics()->create($request->all());

        return Redirect::route('characteristics.show', $characteristic);
    }

    /**
     * Display the specified resource.
     */
    public function show(Characteristic $characteristic)
    {
        if (auth()->user()->cannot('view', $characteristic)) {
            abort(403);
        }

        return Inertia::render('Characteristics/Show', ['characteristic' => $characteristic]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Characteristic $characteristic)
    {
        if (auth()->user()->cannot('update', $characteristic)) {
            abort(403);
        }

        return Inertia::render('Characteristics/Edit', ['characteristic' => $characteristic]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCharacteristicRequest $request, Characteristic $characteristic): RedirectResponse
    {
        if (auth()->user()->cannot('update', $characteristic)) {
            abort(403);
        }

        $characteristic->update($request->all());

        return Redirect::route('characteristics.edit', $characteristic);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Characteristic $characteristic): RedirectResponse
    {
        if (auth()->user()->cannot('delete', $characteristic)) {
            abort(403);
        }

        $characteristic->delete();

        return Redirect::route('characteristics.index');
    }
}
