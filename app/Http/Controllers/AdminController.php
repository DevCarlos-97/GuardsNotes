<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Note;
use App\Models\Oven;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    
    public function index(){
        $user = User::find(session('user_id'));
        $users = User::orderBy('name', 'ASC')->get();
        $ovens = Oven::join('areas', 'areas.id', '=', 'ovens.area_id')
            ->select('ovens.*','areas.name AS area')
            ->orderBy('ovens.area_id','ASC')
            ->get();
        $areas = Area::join('users', 'users.id', '=','areas.user_id')
            ->select('areas.*','users.name AS responsible')
            ->orderBy('areas.name','ASC')
            ->get();
        $notes = Note::join('users', 'users.id', '=','notes.user_id')
            ->select('notes.*', 'users.name AS responsible')
            ->get();
        return view('admin',['user' => $user, 'users'=> $users, 'ovens'=> $ovens, 'areas'=> $areas, 'notes'=> $notes]);
    }

    // User tab functions

    public function createUser(Request $request) {
        $request->validate([
            'userName' => ['required'],
            'user' => ['required', 'unique:users,user'],
            'password' => ['required'],
            'rol' => ['required']
        ]);

        $user = new User();
        $user->name = $request->userName;
        $user->user = $request->user;
        $user->status = 1;
        $user->rol = $request->rol;
        $user->password = Hash::make($request->password);

        if ($user->save()) {
            return redirect(route('admin'))->with('success', 'El usuario se creo correctamente');
        }
    }

    public function getUser(Request $request) {
        $user_edit = User::find($request->id);
        return $user_edit;
    }

    public function editUser(Request $request){
        $request->validate([
            'editUserName' => ['required'],
            'editUser' => ['required'],
            'editRol' => ['required']
        ]);

        $user = User::find($request->id_user);

        $user->name = $request->editUserName;
        $user->user = $request->editUser;
        $user->rol = $request->editRol;

        if ($request->editPassword != '') {
            $user->password = Hash::make($request->editPassword);
        } 

        if ($user->save()) {
            return redirect(route('admin'))->with('edit', 'edit');
        }

        return redirect(route('admin'))->with('error', 'error');
    }

    public function toggleStatusUser(Request $request) {
        $user = User::find($request->id);

        if ($user->status == 1) {
            $user->status = 3;
            $resp = 'deshabilitado';
        }else {
            $user->status = 1;
            $resp = 'habilitado';
        }

        $user->save();
        return response()->json(['status'=>$resp]);
    }

    // Oven tab functions

    public function createOven(Request $request) {
        $request->validate([
            'ovenName' => ['required'],
            'area_oven' => ['required']
        ]);

        $oven = new Oven();
        $oven->name = $request->ovenName;
        $oven->status = 1;
        $oven->area_id = $request->area_oven;

        if($oven->save()) {
            return redirect(route('admin'))->with('oven', 'El horno se creo correctamente');
        }
    }

    public function getOven(Request $request) {
        $oven_edit = Oven::find($request->id);
        return $oven_edit;
    }

    public function editOven(Request $request) {
        $request->validate([
            'editOven' => ['required'],
            'edit_area_oven' => ['required']
        ]);

        $oven = Oven::find($request->id_oven);
        $oven->name = $request->editOven;
        $oven->area_id = $request->edit_area_oven;

        if ($oven->save()) {
            return redirect(route('admin'))->with('edit-oven', 'edit');
        }

        return redirect(route('admin'))->with('error-oven', 'error-edit');
    }

    public function toggleStatusOven(Request $request) {
        $oven = Oven::find($request->id);

        if ($oven->status == 1) {
            $oven->status = 2;
            $resp = 'deshabilitado';
        }else {
            $oven->status = 1;
            $resp = 'habilitado';
        }

        $oven->save();
        return response()->json(['status'=>$resp]);
    }

    // Area tab functions

    public function createArea(Request $request) {
        $request->validate([
            'areaName' => ['required'],
            'user_area' => ['required']
        ]);

        $area = new Area();
        $area->name = $request->areaName;
        $area->status = 1;
        $area->user_id = $request->user_area;

        if($area->save()) {
            return redirect(route('admin'))->with('area', 'El area se creo correctamente');
        }
    }

    public function getArea(Request $request) {
        $area_edit = Area::find($request->id);
        return $area_edit;
    }

    public function editArea(Request $request) {
        $request->validate([
            'editAreaName' => ['required'],
            'edit_user_area' => ['required']
        ]);

        $area = Area::find($request->id_area);

        $area->name = $request->editOven;
        $area->user_id = $request->edit_user_area;

        if ($area->save()) {
            return redirect(route('admin'))->with('edit-area', 'edit');
        }

        return redirect(route('admin'))->with('error-area', 'error-edit');
    }

    public function toggleStatusArea(Request $request) {
        $area = Area::find($request->id);

        if ($area->status == 1) {
            $area->status = 2;
            $resp = 'deshabilitado';
        }else {
            $area->status = 1;
            $resp = 'habilitado';
        }

        $area->save();
        return response()->json(['status'=>$resp]);
    }
    
}
