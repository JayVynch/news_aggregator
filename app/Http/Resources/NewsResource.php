<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
            'type'  => get_class($this),
            'attributes' => [
                'source' => $this->source,
                'title' => $this->title,
                'author' => $this->author,
                'url' => $this->url,
                'category' => $this->category,
                'published_at' => $this->published_at->diffForHumans(),
                'image' => json_encode($this->images),
                'abstract' => $this->abstract,
                'content' => $this->content,
                'created_at' => $this->created_at->diffForHumans(),
            ]
        ];
    }
}
