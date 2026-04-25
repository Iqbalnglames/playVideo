@extends('layouts.app')
@section('title', 'Profile ' . $profile->name)

@section('content')

    <body class="bg-gray-100">
        <div class="max-w-lg mx-auto my-10 bg-white rounded-lg shadow-md p-5">
            <img class="w-32 h-32 rounded-full mx-auto" src="/profile.png" alt="Profile picture">
            <h2 class="text-center text-2xl font-semibold mt-3">{{ $profile->name }}</h2>
            <div class="flex justify-center items-center">
                <svg class="h-5 w-5" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" viewBox="0 0 24 24" stroke="#4a5565">
                <path d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
              </svg>
                <p class="text-center text-gray-600 font-light mt-1">{{ $profile->username }}</p>
            </div>
            <p class="text-center text-gray-600 mt-1">{{ $profile->email }}</p>
            <div class="flex justify-center gap-2 mt-5">
                <a href="{{ route('profile.edit') }}"
                    class="flex select-none items-center gap-2 rounded bg-slate-800 py-2.5 px-4 text-sm font-semibold text-white shadow-md shadow-slate-900/10 transition-all hover:shadow-lg hover:shadow-slate-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
                    <i class='bx bx-edit-alt'></i>
                    Edit Profile
                </a>
                <a href="{{ route('profile.password.edit') }}"
                    class="flex select-none items-center gap-2 rounded bg-slate-800 py-2.5 px-4 text-sm font-semibold text-white shadow-md shadow-slate-900/10 transition-all hover:shadow-lg hover:shadow-slate-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
                    <i class='bx bx-edit-alt'></i>
                    Ganti Password
                </a>
            </div>
        </div>
    </body>
@endsection
