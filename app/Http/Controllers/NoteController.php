<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dashboard(){
        return view('dashboard');
    }




    public function index()
    {
        $notes = Note::all();
        return view('note.note', compact('notes'));
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
        // dd($request->all());
        $request->validate([
            'Note_Description' => 'required',
        ]);

        Note::create([
            'user_id' => auth()->user()->id,
            'note' => $request->Note_Description,
            'tanggal' => Carbon::now(),
        ]);

        return redirect()->route('note');
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
        if ($request->ajax()) {
            $note = Note::find($id);
            $note->note = $request->note;
            $note->save();
            return response()->json(['success' => 'Data is successfully updated']);
        }
        return response()->json(['error' => 'Data is not updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $note = Note::find($id);
        $note->delete();
        return redirect()->route('note');
    }
}
