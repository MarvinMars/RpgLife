<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestRequest;
use App\Http\Requests\UpdateQuestRequest;
use App\Models\Quest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
	    return Inertia::render('Quests/Index', ['quests' => Quest::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
	    return Inertia::render('Quests/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuestRequest $request)
    {
        auth()->user()->quests()->create($request->all());

	    return response(['created' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Quest $quest)
    {
	    if (auth()->user()->cannot('view', $quest)) {
		    abort(403);
	    }

	    return Inertia::render('Quests/Show', ['quest' => $quest]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quest $quest)
    {
	    if (auth()->user()->cannot('update', $quest)) {
		    abort(403);
	    }

	    return Inertia::render('Quests/Edit', ['quest' => $quest]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuestRequest $request, Quest $quest)
    {
	    if (auth()->user()->cannot('update', $quest)) {
		    abort(403);
	    }

	    $quest->update($request->all());

		return response(['updated' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quest $quest)
    {
	    if (auth()->user()->cannot('delete', $quest)) {
		    abort(403);
	    }

	    $quest->delete();

	    return response(['deleted' => true]);
    }
}
