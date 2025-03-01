<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|file|mimes:png,jpeg,jpg|max:2048',
            'location' => 'required',
            
            'apply_start' => 'nullable|date',
            'apply_end' => 'nullable|date|after:apply_start',

            'course_start' => 'nullable|date',
            'course_end' => 'nullable|date|after:course_start',

            'course_slug' => 'required|exists:courses,slug',
            'instructor_email' => 'required|exists:instructors,email',
        ];
    }
}
