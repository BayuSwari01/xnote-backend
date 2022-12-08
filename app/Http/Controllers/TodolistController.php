<?php

namespace App\Http\Controllers;
use App\Models\Todolist;
use Illuminate\Http\Request;

class TodolistController extends Controller
{
    public function getTodolist(Request $request) {
        $todolists = Todolist::where('email',$request->email)->orderBy('tanggal', 'asc')->get();
        return response()->json([
            'status' => true,
            'todolists' => $todolists,
            'email' => $request->email,
        ]);
    }

    public function addTodolist(Request $request) {
        $todolist = Todolist::create([
            'email' => $request->email,
            'todo' => $request->todo,
            'tanggal' => $request->tanggal,
            'status' => $request->status,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Berhasil menambahkan Todo List',
        ]);
    }

    public function editTodolist(Request $request) {
        $todolist = Todolist::find($request->id);

        $todolist->update([
            'todo' => $request->todo,
            'tanggal' => $request->tanggal,
        ]);
        
        return response()->json([
            'status' => true,
            'message' => 'Berhasil mengedit Todo List'
        ]);
    }

    public function deleteTodolist(Request $request) {
        $todolist = Todolist::find($request->id);

        $todolist->delete();

        return response()->json([
            'status' => true,
            'message' => 'Berhasil menghapus Todo List',
        ]);
    }

    public function editStatusTodolist(Request $request) {

        $todolist = Todolist::find($request->id);

        $todolist->update([
            'status' => $request->status,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Berhasil mengedit status Todo List',
        ]);
    }
}
