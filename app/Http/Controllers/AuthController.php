<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {   
        $request->validate([
           'email' =>'required|email',
           'password'=>'required|min:6'
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid login details'], 401);
        }

        $user = Auth::user(); 
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['success'=>true,'token' => $token, 'data' => $user]);
    }

    public function register(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);
        if($user){
            return response()->json(['success'=>true]); 
        }else{
            return response()->json(['success'=>false,'message'=>'Something went wrong, plse contact support']);
        }
      
    }

    public function logout(Request $request){
        if($request->user()){
           $token = $request->user()->tokens()->delete();
            $response = ['message' => 'You have been successfully logged out!'];
            return response($response, 200);
        }else{
           $response = ['message' => 'You have been successfully logged out!'];
           return response($response, 200);
        }
       
    }
}
