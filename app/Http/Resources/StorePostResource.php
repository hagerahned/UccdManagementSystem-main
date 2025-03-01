<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StorePostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Title' => $this->title,
            'Content' => $this->content,
            'Image' => $this->image,
            'Post Slug' => $this->slug,
            'Post Date' => Carbon::parse($this->start_at)->format('F j, Y h:i A'),
        ];
    }
}
