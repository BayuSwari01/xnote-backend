<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request) {
        //membuat validator
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
            //cek lg ini buat apa
            // 'level_id' => 'required',
        ]);

        //cek apakah ada yg gagal dari validator
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ]);
        }

        //menyimpan model ke database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            //membuat hash dari password
            'password' => Hash::make($request->password),
        ]);
        
        // $user->save();
        
        //membuat token
        $token = $user->createToken('auth_token')->plainTextToken;
        
        //mengembalikan data berupa json
        return response()->json([
            'email' => $user->email,
            'status' => true,
            'data' => $user,
            'token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function login(Request $request) {
        //jika proses autentikasi gagal maka akan mengembalikan pesan unauthorized
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = User::where('email', $request->email)->FirstOrFail();
        
            //membuat token
            $token = $user->createToken('auth_token')->plainTextToken;
            
            //jika login berhasil akan memberikan response berikut
            return response()->json([
                'email' => $user->email,
                'status' => true,
                'message' => 'Login Success',
                'token' => $token,
                'token_type' => 'Bearer'
            ]);
        }

        return response()->json([
            'status' => false,
            'email' => $request->email,
            'password' => $request->password,
            'message' => 'Unauthorized',
        ], 401);   
    }

    public function logout() {
        //menghapus token (ini emang ada error tapi tetep jalan)
        Auth::user()->tokens()->delete();
        
        //mengirim pesan
        return response()->json([
            'status' => true,
            'message' => 'Logout Success'
        ]);
    }
}
