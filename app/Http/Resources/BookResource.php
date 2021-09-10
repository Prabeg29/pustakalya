<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "description" => $this->when($request->book, $this->description),
            "coverImage" => $this->cover_image,
            "authors" => $this->commaSeparate($this->authors),
            "genres" => $this->commaSeparate($this->genres),
            'reviews' => $this->when($request->book, BookReviewResource::collection($this->reviews)),
            'isApproved' => $this->is_approved,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
