<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Http\Resources\BookResource;
use App\Http\Filters\BookFilter;
use App\Http\Controllers\ApiController;


class UserBooksController extends ApiController
{
    public function index( $user_id ,BookFilter $filters)
    {
        return BookResource::collection(Book::where('user_id', $user_id)->filter($filters)->paginate());
    }
}
