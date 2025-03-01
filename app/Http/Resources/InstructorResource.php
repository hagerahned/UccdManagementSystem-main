<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InstructorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Name' => $this->name,
            'Username' => $this->username,
            'Email' => $this->email,
            'Phone' => $this->phone,
            'Description' => $this->description,
            'username' => $this->username,
        ];
    }
}
