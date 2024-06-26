<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestRequest;
use App\Http\Requests\UpdateQuestRequest;
use App\Models\Quest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
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
    public function store(StoreQuestRequest $request): RedirectResponse
    {
        $quest = auth()->user()->quests()->create($request->except(['characteristics']));
        $quest->characteristics()->sync($request->get('characteristics'));

        return Redirect::route('quests.show', $quest);
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
    public function update(UpdateQuestRequest $request, Quest $quest): RedirectResponse
    {
        if (auth()->user()->cannot('update', $quest)) {
            abort(403);
        }

        $quest->update($request->except(['characteristics']));
        $quest->characteristics()->sync($request->get('characteristics'));

        return Redirect::route('quests.edit', $quest);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quest $quest): RedirectResponse
    {
        if (auth()->user()->cannot('delete', $quest)) {
            abort(403);
        }

        $quest->delete();

        return Redirect::route('quests.index');
    }

    public function updateStatus(Request $request, Quest $quest): JsonResponse
    {

        if (auth()->user()->cannot('update', $quest)) {
            abort(403);
        }

        $quest->update(['status' => $request->get('status')]);

        return response()->json(['success' => true]);
    }
}
