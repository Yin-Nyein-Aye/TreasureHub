<?php

namespace App\Http\Controllers;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(UserRequest $request){
        $validatedRegisterData = $request->validated();
        $findmail = User::where('email',$request->email)->first();
        if($findmail){
            return response()->json(["Email is already Exist"],400);
        }
        $validatedRegisterData['password'] = Hash::make($request->password);
        $user = User::create($validatedRegisterData);
        return new UserResource($user,'register');
    }

    public function login(UserRequest $request)
    {
        $ValidatedLoginData = $request->validated();
        if(auth()->attempt($ValidatedLoginData)){
            $user = auth()->user();
            $token = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                "user" => new UserResource($user,'login'),
                "token" =>$token
            ],200);
        }
        else {
            return response()->json(["message" => "Username and Password is incorrect"], 400);
        }
    }

    public function logout()
    {
        $user = Auth::guard('api')->user();
        $user->tokens->each(function ($token) {
            $token->delete();
        });
        return response()->json(['message' => 'Logged out successfully']);
    }
}
