<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LoginController extends Controller
{
     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'token_name' => ['required'],
            'email' => ['required'],
            'password' => ['required'],
        ]);

        $user = User::whereEmail($request->email)->first();
        if (Hash::check($request->password, $user->password) == false) {
            throw new NotFoundHttpException('Email or password is invalid');
        }

        $token = $user->createToken($request->token_name);
        return ['token' => $token->plainTextToken];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $login)
    {
        $user = $login;
        $user->tokens()->delete();
        return "user's token have been delete";
    }
}
