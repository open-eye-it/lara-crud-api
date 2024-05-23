<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginSystemController extends Controller
{
    public function signup(Request $request){
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        return response()->json(['status' => 'success']);
    }

    public function signin(Request $request){
        $input = $request->all();
        if(Auth::attempt($input)){
            $user = Auth::user();
            $token = $token = $user->createToken('Lara Crud Api')->accessToken;
            return response()->json(['status' => 'success', 'token' => $token]);
        }else{
            return response()->json(['status' => 'fail']);
        }
    }

    public function signout_confirm(){
        Auth::user()->token()->revoke();
        return response()->json([
            'success' => true,
            'message' => 'Signout successfully',
        ], 200);
    }

    public function signin_check(){
        if(Auth::check()){
            $token = Auth::user()->token();
            return response()->json(['status' => 'success', 'message' => 'Authorized'], 200);
        }else{
            return response()->json(['status' => 'fail', 'message' => 'Unauthorized'], 401);
        }
    }
}
