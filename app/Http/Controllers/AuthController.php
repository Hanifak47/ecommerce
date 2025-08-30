<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\user;


class AuthController extends Controller
{
    //login khusus admin
    public function login(Request $request)
    {


        // dd("joss banget gutys");

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required',
            'remember' => 'boolean'
        ]);
        $remember = $credentials['remember'] ?? false;

        unset($credentials['remember']);
        // dd("josssss");

        if (!Auth::attempt($credentials, $remember)) {
            return response([
                'message' => 'Email or password is incorrect'
            ], 422);
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // dd('berhasil');
        if (!$user->is_admin) {
            Auth::logout();
            return response([
                'message' => 'You don\'t have permission to authenticate as admin'
            ], 403);
        }


        $token = $user->createToken('main')->plainTextToken;

        // saat login langsung simpan data user pada resource
        return response([
            'user' => new UserResource($user),
            'token' => $token
        ]);

    }

    public function logout(Request $request)
    {
        /** @var \App\Models\User $user */
        // dd($request->user(), $request->bearerToken());
        $user = Auth::user();
        $user->currentAccessToken()->delete();
        return response('', 204);
    }


    // memanggil data user yang tersimpan dalam resource
    public function getUser(Request $request)
    {
        return new UserResource($request->user());

    }
}
