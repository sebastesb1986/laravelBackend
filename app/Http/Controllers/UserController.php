<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;

class UserController extends Controller
{
    public function userList(Request $request)
    {
        // Obtenermos el usuario logueado
        $auth = auth()->user();

        if($request->ajax()){
            // Lista de usuarios registrados
            $users = User::select('id', 'name')->get();

            return response()->json(['users' => $users, 'auth' => $auth]);
        }

    }

    public function show(Request $request, $id)
    {
        if($request->ajax()){

            $user = User::select('id', 'name')
                        ->findOrFail($id);

            return response()->json([ 'user' => $user ]);
            
        }
    }
}
