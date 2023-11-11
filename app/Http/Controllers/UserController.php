<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function userList()
    {
        $users = User::select('id', 'name')->get();

        return response()->json(['users' => $users]);

    }

    public function show($id)
    {

        $User = User::select('id', 'name')
                    ->findOrFail($id);

        return response()->json([ 'user' => $user ]);

    }
}
