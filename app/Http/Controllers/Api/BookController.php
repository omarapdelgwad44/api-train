<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Http\Resources\BookResource;
use App\Http\Filters\BookFilter;
use App\Http\Controllers\ApiController;


class BookController extends ApiController
{
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

    public function store(Request $request)
    {
        $book = Book::create($request->all());
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
