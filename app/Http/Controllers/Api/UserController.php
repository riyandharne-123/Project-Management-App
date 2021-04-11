<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\User;
use Auth;

class UserController extends Controller
{
    //login function api
    public function login(Request $request)
    {
      $credentials = $request->only('email','password');
      if(Auth::attempt($credentials)){
      $token = Str::random(80);
      Auth::user()->api_token = $token;
      Auth::user()->save();
      return response()->json(['token' => $token], 200);
      }
      return response()->json(['status' => 'wrong credentials!'], 403);
    }

    //register function api
    public function register(Request $request)
    {
        
      $token = Str::random(80);
      User::create([
        'name' => $request['name'],
        'email' => $request['email'],
        'password' => bcrypt($request['password']),
        'api_token' => $token,
        ]);
      return response()->json(['token' => $token], 200);
      
      //return response()->json(['status' => 'wrong credentials!'], 403);
    }

    //verying token
    public function verify(Request $request)
    {
      return $request->user()->only('api_token');
    }
}
