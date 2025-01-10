<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserPreferenceResource extends JsonResource
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
                'news_id' => $this->news_id,
                'user_ip' => $this->user_ip,
                'news' => new NewsResource($this->news->first()),
            ]
        ];
    }
}
