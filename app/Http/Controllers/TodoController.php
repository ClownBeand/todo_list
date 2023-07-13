<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $todos = $user->todos;
        return view('todo', compact('todos'));
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
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('user.todos')->withErrors($validator);
        }

        $validatedData = $request->validate([
            'title' => 'required|max:255',
        ]);
    
        $todo = new Todo();
        $todo->title = $validatedData['title'];
        $todo->user_id = Auth::id();
        $todo->save();
    
        return redirect()->route('user.todos')->with('success', 'Задача успешно создана');
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
        $todo = Auth::user()->todos()->findOrFail($id);
        return view('edit-todo', compact('todo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('user.todos.edit', ['todo' => $id])->withErrors($validator);
        }

        $todo = Auth::user()->todos()->findOrFail($id);
        $todo->title = $request->get('title');
        $todo->is_completed = $request->get('is_completed');
        $todo->save();

        return redirect()->route('user.todos')->with('success', 'Updated Todo');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $todo = Auth::user()->todos()->findOrFail($id);
        $todo->delete();
        return redirect()->route('user.todos')->with('success', 'Deleted Todo');
    }
}
