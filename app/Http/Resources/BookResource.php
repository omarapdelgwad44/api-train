<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public static $wrap = 'book';

    public function toArray(Request $request): array
    {
        return [
            'type' => 'book',
            'id' => $this->id,
            'attributes' => [
                'title' => $this->title,
                'author' => $this->author,
                'description' => $this->when(
                    $request->routeIs('books.show'),
                    $this->description
                ),
                'published_year' => $this->published_year,
                'is_published' => $this->is_published
            ],
            'relationships' => [
                'user' => [
                    'data' => [
                        'type' => 'user',
                        'id' => $this->user_id,
                    ]
                ]
            ],
            'includes' => new UserResource($this->whenLoaded('user')),
            'links' => $this->when(
                $request->routeIs('books.show'),
                [
                    'self' => route('books.show', $this->id),
                ]
            ),
        ];
    }
}
