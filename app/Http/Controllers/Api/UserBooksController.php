<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Http\Resources\BookResource;
use App\Http\Filters\BookFilter;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\StoreBook;
use App\Models\User;


class UserBooksController extends ApiController
{
    public function index( $user_id ,BookFilter $filters)
    {
        return BookResource::collection(Book::where('user_id', $user_id)->filter($filters)->paginate());
    }
        public function store($user_id,StoreBook $request)
    {
        try {
            $user = User::findOrFail($user_id);
            
        } catch (ModelNotFoundException $e) {
            return $this->error('User not found', 404);
        }
        $book = $user->books()->create($request->data['attributes']);
        return new BookResource($book);
    }

}
