<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreInstructorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Name' => $request->name,
            'Email' => $request->email,
            'Phone' => $this->phone,
            'Description' => $request->description,
            'username' => $this->username,
        ];
    }
}
