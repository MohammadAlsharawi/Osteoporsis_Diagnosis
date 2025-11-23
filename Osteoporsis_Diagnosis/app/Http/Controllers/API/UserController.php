<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequests\addUserRequest;
use App\Http\Requests\UserRequests\deleteUserRequest;
use App\Http\Requests\UserRequests\forceDeleteUserRequest;
use App\Http\Requests\UserRequests\getAllUsersRequest;
use App\Http\Requests\UserRequests\LoginRequest;
use App\Http\Requests\UserRequests\RegisterRequest;
use App\Http\Requests\UserRequests\resetPasswordRequest;
use App\Http\Requests\UserRequests\restoreUserRequest;
use App\Http\Requests\UserRequests\searchUserRequest;
use App\Http\Requests\UserRequests\sendResetLinkPasswordRequest;
use App\Http\Requests\UserRequests\showDeletedUsersRequest;
use App\Http\Requests\UserRequests\UpdateUserRequest;
use App\Http\Requests\UserRequests\userUpdatePassswordRequest;
use App\Http\Requests\UserRequests\userUpdateProfileRequest;
use App\Models\User;
use App\Services\UserService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function deleteUser(deleteUserRequest $request,$id)
    {
        try {
            $user = $this->userService->deleteUser($id);
            return $this->successResponse($user, 'User deleted successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function forceDeleteUser(forceDeleteUserRequest $request, $id)
    {
        try {
            $user = $this->userService->forceDeleteUser($id);
            return $this->successResponse($user, 'User permanently deleted successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
    public function showDeletedUsers(showDeletedUsersRequest $request)
    {
        try {
            $deletedUsers = $this->userService->showDeletedUsers();
            return $this->successResponse($deletedUsers, 'Deleted users retrieved successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function restoreUser(restoreUserRequest $request, $id)
    {
        try {
            $user = $this->userService->restoreUser($id);
            return $this->successResponse($user, 'User restored successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function getAllUsers(getAllUsersRequest $request)
    {
        try {
            $users = $this->userService->getAllUsers();
            return $this->successResponse($users, 'All users retrieved successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function searchUsers(searchUserRequest $request)
    {
        $validated = $request->validated();
        try {
            $users = $this->userService->searchUsers($validated['name'] ?? null, $validated['email'] ?? null);
            return $this->successResponse($users, 'Search completed successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function updateUser(UpdateUserRequest $request, $id)
    {
        $validated = $request->validated();
        try {
            $user = $this->userService->updateUser($id, $validated);
            return $this->successResponse($user, 'User information updated successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function logout()
    {
        $user = auth()->user();
        try {
            $this->userService->logout($user);
            return $this->successResponse([], 'Logged out successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function updateProfile(userUpdateProfileRequest $request)
    {
        $user = Auth::user();
        try {
            $response = $this->userService->updateProfile($user, $request->validated());
            return $this->successResponse($response, 'Profile updated successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function updatePassword(userUpdatePassswordRequest $request)
    {
        $user = Auth::user();
        try {
            $response = $this->userService->updatePassword($user, $request->current_password, $request->new_password);
            return $this->successResponse($user, 'Password updated successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function showProfile()
    {
        try {
            $response = $this->userService->showProfile();
            return $this->successResponse($response, 'Profile retrieved successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
