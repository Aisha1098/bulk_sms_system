<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function index()
    {
        $users = User::get();

        return UserResource::collection($users);
    }

    public function show($user)
    {
        $users = User::findOrFail($user);

        return new UserResource($users);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'is_active' => 'sometimes|boolean',
            'profile_pic' => 'required',
            'name' => 'required|max:30',
            'email' => 'required|unique:App\Models\User,email|email',
            'contact' => 'required',
            'email_verified_at' => 'required',
            'password' => 'required|password|min:3'
        ]);
        $user = User::create($validated);

        return new UserResource($user);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'is_active' => 'sometimes|boolean',
            'profile_pic' => 'required',
            'name' => 'required|max:30',
            'email' => 'required|unique:App\Models\User,email|email',
            'contact' => 'required',
            'email_verified_at' => 'required',
            'password' => 'required|password|min:3'
        ]);
        $user->update($validated);

        return new UserResource($user);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return UserResource::collection(User::all());
    }
}
