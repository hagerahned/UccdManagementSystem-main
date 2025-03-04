<h2>{{ $course->title }}</h2>
<p>{{ $course->description }}</p>


<form action="{{ route('like.toggle') }}" method="POST">
    @csrf
    <input type="hidden" name="likeable_id" value="{{ $course->id }}">
    <input type="hidden" name="likeable_type" value="course">
    <button type="submit">👍 Like</button>
</form>

<form action="{{ route('attendance.mark') }}" method="POST">
    @csrf
    <input type="hidden" name="course_id" value="{{ $course->id }}">
    <button type="submit">📌 Attendance Registration</button>
</form>
