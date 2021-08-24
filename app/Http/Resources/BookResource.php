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
            'id' => $this->id,
            'authors' => AuthorResource::collection($this->authors),
            'title' => $this->title,
            'description' => $this->description,
            'date' => $this->date,
            'created_at' => $this->created_at
        ];
    }
}
