<?php

namespace App\Http\Controllers;

use App\Models\todolist;
use Illuminate\Http\Request;

class TodoListController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function fetch()
    {
        $todolist = todolist::all();
        return response()->json($todolist);
    }

    public function index()
    {   
        return view('todolist.todolist');
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
        if ($request->ajax()) {
            $data = $request->all();
            $todolist = todolist::create($data);
            return response()->json($todolist);
        }
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
            $data = $request->all();
            $todolist = todolist::find($id);
            $todolist->update($data);
            return response()->json($todolist);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $todolist = todolist::find($id);
        $todolist->delete();
        return response()->json($todolist);
    }
}
