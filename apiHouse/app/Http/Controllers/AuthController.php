<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
    public function register(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required',
                'email' => 'required|unique:users,email',
                'password' => 'required|min:8',
                'role' => 'required',
                'adress' => 'required',
                'phone' => 'required|numeric'
            ]);
            if (!$data) {
                return response()->json(['message' => 'Validation failed.'], 400);
            }
            $data['password'] = Hash::make($data['password']);
            DB::beginTransaction();
            $user = User::create($data);
            $success['user'] =  $user;
            DB::commit();
            return $this->sendResponse($success, 'User register successfully.');
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['message' => 'Failed to register user.', 'status' => $th->getMessage()], 500);
        }
    }
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->guard()->attempt($credentials)) {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }

        $success = $this->respondWithToken($token);

        return $this->sendResponse($success, 'User login successfully.');
    }
    public function profile()
    {
        $success = auth()->guard()->user();

        return $this->sendResponse($success, 'Refresh token return successfully.');
    }
    public function refresh()
    {
        $success = $this->respondWithToken(Auth::refresh());

        return $this->sendResponse($success, 'Refresh token return successfully.');
    }
    public function logout()
    {
        try {
            auth()->guard()->logout();
            return $this->sendResponse([], 'Successfully logged out.');
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Failed to log out.', 'failed' => $th->getMessage()], 500);
        }
    }
    public function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ];
    }
}
