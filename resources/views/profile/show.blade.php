@extends('layouts.app')

@section('content')
    <h1>My Profile</h1>

    @if($profile->profile_picture)
        <img src="{{ asset('storage/' . $profile->profile_picture) }}" alt="Profile Picture" width="150">
    @endif

    <p><strong>Bio:</strong> {{ $profile->bio }}</p>
    <p><strong>Phone:</strong> {{ $profile->phone }}</p>
    <p><strong>Address:</strong> {{ $profile->address }}</p>

    <a href="{{ route('profile.edit') }}">Edit Profile</a>
@endsection
