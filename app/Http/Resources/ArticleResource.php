<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
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
            'title' => $this->title,
            'url' => $this->url,
            'content' => $this->content,
            'full_content' => $this->full_content,
            'starred' => $this->starred,
            'read' => $this->read,
            'image' => $this->image,
            'date' => $this->created_at,
            'feed' => new FeedResource($this->whenLoaded('feed'))
        ];
    }
}
