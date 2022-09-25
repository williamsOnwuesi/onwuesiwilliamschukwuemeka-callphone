<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Image;

class AuthController extends Controller
{


    public function __construct() {

        $this->middleware('auth:api', ['except' => ['login','register']]);

    }


    public function login(Request $request) {

        $request->validate([

            'email' => 'required|string|email',
            'password' => 'required|string',

        ]);

        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);

        if (!$token) {

            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);

        }

        $user = Auth::user();

        return response()->json([

                'status' => 'success',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]

            ]);

    }

    
    public function uploadProfilePicture (Request $request) {

        $this->validate($request, [

            'image' => 'required|image|mimes:jpg,jpeg|max:3000',

        ]);

        $image_path = $request->file('image')->store('image', 'public');

        $data = Image::create([

            'image' => $image_path,

        ]);

        return responce()->json([

            'status' => 'Image Was Succesfully Uploaded',

        ]);
        
    }
    

    public function register(Request $request) {

        $request->validate([

            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',

        ]);

        $user = User::create([

            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),

        ]);

        $token = Auth::login($user);

        return response()->json([

            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]

        ]);

    }


}

