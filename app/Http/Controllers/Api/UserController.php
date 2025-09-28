<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Controllers\ApiController;

class UserController extends ApiController
{
    public function index()
    {
        if ($this->include('books')) {
            return UserResource::collection(User::with('books')->paginate());
        }
        return UserResource::collection(User::paginate());
    }

    public function show(User $user)
    {
        if ($this->include('books')) {
            return new UserResource($user->load('books'));
        }
        return new UserResource($user);
    }

    public function store(Request $request)
    {
        $user = User::create($request->all());
        return new UserResource($user);
    }

    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        return new UserResource($user);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }
}
