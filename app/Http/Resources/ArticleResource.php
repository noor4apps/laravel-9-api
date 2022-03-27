<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
//            'user' => new UserResource($this->user),  // always appear
            'user' => new UserResource($this->whenLoaded('user')),  // It appears only when the word "with" is present in the controller
        ];
    }
}
