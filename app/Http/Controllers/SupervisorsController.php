<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Note;
use App\Models\Oven;
use App\Models\User;
use Illuminate\Http\Request;

class SupervisorsController extends Controller
{

    public function index()
    {
        $user = User::find(session('user_id'));
        $notes = Note::orderBy('id','DESC')
            ->orderBy('status','ASC')
            ->where('user_id', $user->id)
            ->whereIn('status',[1,2])
            ->get();
        $ovens = Oven::join('areas', 'areas.id', '=', 'ovens.area_id')
            ->select('ovens.name', 'ovens.id')
            ->where('areas.user_id', '=', $user->id)
            ->where('ovens.status','=',1)
            ->get();
        return view('supervisors', ['notes' => $notes, 'user' => $user, 'ovens' => $ovens]);
    }

    
    public function createNote(Request $request)
    {
        $request->validate([
            'oven' => 'required',
            'time' => 'required',
            'instructions' => 'required'
        ]);

        $note = new Note();
        $note->oven = $request->oven;
        $note->description = $request->instructions . " a las " . $request->time;
        $note->status = 1;
        $note->user_id = session('user_id');

        $note->save();

        return back()->with('success', 'success');
    }

    public function editNote(Request $request) {
        $request->validate([
            'edit_oven' => 'required',
            'edit_instructions' => 'required'
        ]);

        $note = Note::find($request->id_note);
        $note->oven = $request->edit_oven;
        $note->description = $request->edit_instructions;
        $note->save();
        
        return back()->with('edit', 'edit');
    }

    public function getNote(Request $request){
        $note = Note::find($request->id);
        return $note;
    }

    public function deleteNote(Request $request) {

        $note = Note::find($request->id);
        $note->status = 3;
        if($note->save()) {
            return back()->with('success','Nota eliminada');
        }

        return back()->with('error', 'No se pudo eliminar la nota');
    }
}
