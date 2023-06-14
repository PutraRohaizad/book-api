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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        $user = User::whereEmail($request->email)->first();
        if (! isset($user)) {
            throw new NotFoundHttpException('Email not exists');
        }
        if (Hash::check($request->password, $user->password) == false) {
            throw new NotFoundHttpException('Password is invalid');
        }

        $token = $user->createToken('user_login');

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
