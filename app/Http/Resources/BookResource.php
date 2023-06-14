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
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,  
            'title' => $this->title,  
            'genre' => $this->genre,  
            'author' => $this->author,
            'page_count' => $this->page_count,
            'status' => strtoupper($this->status),
            'book_histories' => BookHistoryResource::collection($this->bookHistories)
        ];
    }
}
