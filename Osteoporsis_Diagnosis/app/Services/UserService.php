<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function login(array $credentials)
    {
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw new Exception('Invalid credentials.');
        }

        if ($user->status !== 'accepted') {
            throw new Exception('Your account is not yet approved. Please wait for admin.');
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'msg' => 'Login successful',
            'success' => true,
            'user'    => $user,
            'token'   => $token
        ];
    }

    public function register(array $data)
    {
        try{
            $user = User::create([$data]);
            return $user;
        }catch (\Exception $e){
            throw $e->getMessage();
        }
    }
    public function addUser($data)
    {
        try {
            $data['password'] = Hash::make($data['password']);
            $user = User::create($data);
            return $user;
        } catch (\Exception $e) {
            throw $e->getMessage();
        }
    }
}
