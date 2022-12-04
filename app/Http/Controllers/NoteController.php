<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function getNotes(Request $request) {
        $notes = Note::where('email', $request->email)->get();
        // $notes = Note::all();
        return response()->json([
            'status' => true,
            'notes' => $notes,
            'email' => $request->email
        ]);
    }

    public function addNote(Request $request) {
        $note = Note::create([
            'email' => $request->email,
            'judul' => $request->judul,
            'catatan' => $request->catatan,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Berhasil menambahkan note',
        ]);
    }

    public function editNote(Request $request) {
        $note = Note::find($request->id);

        $note->update([
            'judul' => $request->judul,
            'catatan' => $request->catatan,
        ]);
        return response()->json([
            'status' => true,
            'messsage' => 'Berhasil mengedit note',
        ]);
    }

    public function deleteNote(Request $request) {
        $note = Note::find($request->id);

        $note->delete();
        return response()->json([
            'id' => $request->id,
            'status' => true,
            'message' => 'Berhasil menghapus note',
        ]);
    }
}
