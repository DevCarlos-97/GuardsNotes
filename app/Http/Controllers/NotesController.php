<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;

class NotesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::find(session('user_id'));
        $notes = Note::join('areas','areas.user_id', '=', 'notes.user_id')->select('notes.*', 'areas.name')->where('notes.status',1)->get();
        return view('notes', ['notes' => $notes,'user' => $user]);
    }

    public function doneNote(Request $request) {
        $note = Note::find($request->id);
        $note->comment = $request->comment;
        $note->status = 2;
        $note->save();
        
        return back()->with('success', 'success');
    }
}
