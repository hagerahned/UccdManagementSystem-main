<form action="{{ route('attendance.mark') }}" method="POST">
    @csrf
    <input type="hidden" name="course_id" value="{{ $course->id }}">

    @php
        $alreadyMarked = $course->attendances->where('user_id', auth()->id())->where('date', now()->toDateString())->count() > 0;
    @endphp

    <button type="submit" {{ $alreadyMarked ? 'disabled' : '' }}>
        {{ $alreadyMarked ? '✅ Attendance registered' : '📌 Attendance Registration' }}
    </button>
</form>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

