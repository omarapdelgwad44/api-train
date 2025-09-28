<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Controllers\ApiController;
use App\Http\Filters\UserFilter;

class UserController extends ApiController
{
    public function index(UserFilter $filters)
    {
            return UserResource::collection(User::filter($filters)->paginate());
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
