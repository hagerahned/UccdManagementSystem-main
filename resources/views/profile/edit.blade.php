@extends('layouts.app')

@section('content')
    <h1>Edit Profile</h1>
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label>Bio:</label>
        <textarea name="bio">{{ old('bio', $profile->bio) }}</textarea>

        <label>Phone:</label>
        <input type="text" name="phone" value="{{ old('phone', $profile->phone) }}">

        <label>Address:</label>
        <input type="text" name="address" value="{{ old('address', $profile->address) }}">

        <label>Profile Picture:</label>
        <input type="file" name="profile_picture">

        <button type="submit">Save Changes</button>
    </form>
@endsection
