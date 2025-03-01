<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'image' => 'required|file|mimes:png,jpeg,jpg|max:2048',

            'course_start' => 'required|date',
            'course_end' => 'required|date|after:course_start',

            'apply_start' => 'required|date',
            'apply_end' => 'required|date|after:apply_start',
            
            'instructor_email' => 'required|exists:instructors,email',
            'location' => 'required',
        ];
    }
}
