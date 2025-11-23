<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequests\addUserRequest;
use App\Http\Requests\UserRequests\LoginRequest;
use App\Http\Requests\UserRequests\RegisterRequest;
use App\Services\UserService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiResponse;
    protected $userService;

    public function __construct(UserService $userService)
    {
    $this->userService = $userService;
    }

    public function login(LoginRequest $request)
    {
        $validatedData = $request->validated();
        try{
            $response = $user = $this->userService->login($validatedData);
            return $this->successResponse($response, 'Login successfully.');
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    public function register(RegisterRequest $request)
    {
        $validatedData = $request->validated();
        try{
            $response = $user = $this->userService->register($validatedData);
            return $this->successResponse($response, 'Registration successful. Please wait for admin approval.');
        }catch(\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    public function addUser(addUserRequest $request)
    {
        $validated = $request->validated();
        try {
            $user = $this->userService->addUser($validated);
            return $this->successResponse($user, 'User added successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

}
