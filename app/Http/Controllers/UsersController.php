<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    //

    public function showAllUsers()
    {
        //
        $users = User::all();
        return response()->json($users);
    }
    public function AuthRouteAPI(Request $request)
    {
        return $request->user();
    }

}
