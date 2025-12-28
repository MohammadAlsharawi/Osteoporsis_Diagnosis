<?php

namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;

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
            $user = User::create($data);
            return $user;
        }catch (Exception $e){
            throw $e;
        }
    }
    public function searchUsers($name = null, $email = null)
    {
        try {
            $query = User::query();
            if ($name) {
                $query->where('name', 'LIKE', "%{$name}%");
            }
            if ($email) {
                $query->orWhere('email', 'LIKE', "%{$email}%");
            }
            return $query->get();
        } catch (Exception $e) {
            throw $e;
        }
    }

    
    public function logout($user)
    {
        try {
            $user->tokens()->delete();
            return [];
        } catch (Exception $e) {
            throw $e;
        }
    }
    public function updateProfile($user, $validatedData)
    {
        try {
            $user->update($validatedData);
            return $user;
        } catch (\Exception $e) {
            throw $e;
        }
    }
    public function updatePassword($user, $currentPassword, $newPassword)
    {
        try {
            if (!Hash::check($currentPassword, $user->password)) {
                throw new \Exception('Current password is incorrect.');
            }
            $user->password = Hash::make($newPassword);
            $user->save();
            return $user;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function showProfile()
    {
        try {
            $user = Auth::user();
            return $user;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
