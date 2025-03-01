<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RetriveStudentsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Student Name' => $this->name,
            'Student Email' => $this->email,
            'Student Year' => $this->current_year,
            'Student Department' => $this->department
        ];
    }
}
