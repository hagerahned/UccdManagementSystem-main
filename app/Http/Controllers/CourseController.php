<?php
namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('category')->get();
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('courses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'category_id' => 'required|exists:categories,id',
        ]);

        Course::create($request->all());

        return redirect()->route('courses.index')->with('success', 'Course added successfully!');
    }

    public function show(Course $course)
    {
        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $categories = Category::all();
        return view('courses.edit', compact('course', 'categories'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'category_id' => 'required|exists:categories,id',
        ]);

        $course->update($request->all());

        return redirect()->route('courses.index')->with('success', 'Course updated successfully!');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully!');
    }
}
