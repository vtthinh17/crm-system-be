<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use http\Env\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(LoginUserRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('My app')->plainTextToken;
            return response()->json( ['token'=>$token, 'user' => $user], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function register(StoreUserRequest $request): JsonResponse
    {
        try{
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            return response()->json(['user' => $user],200);
        }catch (\Exception $exception){
            return response()->json(['error' => $exception]);
        }

    }

    public function logout(Request $request): JsonResponse{
        $credentials = $request->input('user_token');
        DB::delete('token',$credentials);
        return response()->json(['Logout -> Token delete'],200);
    }
}
