<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreCourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Course Title' => $this->title,
            'Course Description' => $this->description,
            'Course Image' => $this->image,
            'Course Slug' => $this->slug,
            'Course Instructor' => [
                'Name' => $this->instructor->name,
                'Email' => $this->instructor->email,
            ],
            "Applyment Period" => [
                'Start' => Carbon::parse($this->apply_start)->format('F j, Y h:i A'),
                'End' => Carbon::parse($this->apply_end)->format('F j, Y h:i A'),
            ],
            "Course Period" => [
                'Start' => Carbon::parse($this->start_at)->format('F j, Y h:i A'),
                'End' => Carbon::parse($this->end_at)->format('F j, Y h:i A'),
            ],
        ];
    }
}
