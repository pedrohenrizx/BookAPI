<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'synopsis' => $this->synopsis,
            'isbn' => $this->isbn,
            'year' => $this->year,
            'language' => $this->language,
            'pages' => $this->pages,
            'cover_url' => $this->cover_url,
            'status' => $this->status,
            'average_rating' => $this->average_rating,
            'publisher' => new PublisherResource($this->whenLoaded('publisher')),
            'authors' => AuthorResource::collection($this->whenLoaded('authors')),
            'themes' => ThemeResource::collection($this->whenLoaded('themes')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}