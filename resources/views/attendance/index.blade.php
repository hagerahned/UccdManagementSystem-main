<h2> Course Attendance List: {{ $course->title }}</h2>

<table>
    <thead>
        <tr>
            <th>Student Name</th>
            <th>Date</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($attendances as $attendance)
            <tr>
                <td>{{ $attendance->user->name }}</td>
                <td>{{ $attendance->date }}</td>
                <td>{{ $attendance->status ? 'Roger that ✅' : 'absent ❌' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>






