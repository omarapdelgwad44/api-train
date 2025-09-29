<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Http\Resources\BookResource;
use App\Http\Filters\BookFilter;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Api\StoreBook;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;



class UserBooksController extends ApiController
{
    use ApiResponse;
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

public function destroy($user_id,$book_id)
{
    try {
        $book = Book::findOrFail($book_id);

        if ($book->user_id == $user_id) {
            $book->delete();
            return $this->success('Book deleted successfully');
        } else {
            return $this->error('This book does not belong to the given user', 403);
        }

    } catch (ModelNotFoundException $e) {
        return $this->error('Book not found', 404);
    }
}

}
