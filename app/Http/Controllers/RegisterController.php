<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'name' => ['required'],
            'email' => ['required'],
            'password' => ['required'],
        ]);

        $user = new User;
        $user->fill($data);
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            'user' => $user,
            'msg' => 'User have been register.',
        ], 201);
    }
}
