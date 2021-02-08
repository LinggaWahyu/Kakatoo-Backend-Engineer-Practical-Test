<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function login(Request $request) 
    {
        $rules = [
            'username' => 'required|string',
            'password' => 'required|string|min:8',
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'invalid login'
            ], 401);
        }

        if(!Auth::attempt(['username' => request('username'), 'password' => request('password')])){
            return response()->json([
                'message' => 'invalid login'
            ], 401);
        }

        $user = User::find($this->guard()->user()->id);

        $token = strtoupper(Str::random(30));
        $api_token = hash('sha256', $token);

        $user->fill([
            'api_token' => $api_token
        ]);
        $user->save();

        return response()->json([
            'token' => $token,
            'profile' => $user->profile->name
        ]);
    }

    public function logout(Request $request)
    {
        $token = hash('sha256', $request->header('Authorization'));
        $user = User::where('api_token', $token)->first();

        $user->fill([
            'api_token' => null
        ]);
        $user->save();

        return response()->json([
            'message' => 'logout success'
        ]);
    }

    public function register(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'username' => 'required|string|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'profile_id' => 'required|integer|exists:App\Models\Profile,id',
            'skill' => 'integer|nullable|exists:App\Models\Skill,id'
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Data cannot be processed'
            ], 422);
        }

        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return response()->json([
            'message' => 'create success'
        ]);
    }

    public function show(Request $request)
    {
        $token = hash('sha256', $request->header('Authorization'));
        $user = User::where('api_token', $token)->first();

        unset($user->api_token);
        unset($user->created_at);
        unset($user->updated_at);

        return response()->json([
            'data' => $user
        ]);
    }

    protected function guard()
    {
        return Auth::guard();
    }
}
