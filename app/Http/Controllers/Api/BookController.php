<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Http\Resources\BookResource;
use App\Http\Filters\BookFilter;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\StoreBook;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\User;
use App\Traits\ApiResponse;


class BookController extends ApiController
{
    use ApiResponse;
    public function index( BookFilter $filters)
    {
        return BookResource::collection(Book::filter($filters)->paginate());
    }

    public function show(Book $book)
    {
        if ($this->include('user')) {
            return new BookResource($book->load('user'));
        }

        return new BookResource($book);
    }

    public function store(StoreBook $request)
    {
        try {
            $user = User::findOrFail($request->data['relationships']['user']['data']['id']);
            
        } catch (ModelNotFoundException $e) {
            return $this->error('User not found', 404);
        }

        $book = $user->books()->create($request->data['attributes']);
        return new BookResource($book);
    }

    public function update(Request $request, Book $book)
    {
        $book->update($request->all());
        return new BookResource($book);
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json(null, 204);
    }
}
