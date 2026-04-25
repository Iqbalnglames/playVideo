@extends('layouts.app')
@section('title', $video->title)

@section('content')
<a href="{{ route('video') }}" class="text-blue-500 hover:text-blue-700">← Kembali</a>
    <div class="bg-white p-6 rounded-2xl shadow-md">
        @if($videoReq && $videoReq->isAccessible() || auth()->user()->role->role_name == 'admin')
            <video width="800" class="rounded-xl mb-2" controls>
                <source src="/storage/{{ $video->video_path }}">
            </video>
        @else
            <div class="w-200 rounded-xl overflow-hidden relative">
                <img src="/storage/{{ $video->thumbnail }}" alt="{{ $video->title }}" class="object-cover w-full h-full" >
                <div class="bg-black absolute z-10 w-full inset-0 opacity-50">
                </div>
                <div class="absolute z-20 inset-x-60 inset-y-52">
                    <p class="text-white">Anda Belum diizinkan memutar video ini</p>
                </div>
            </div>
        @endif
        <div>
            <h1 class="text-xl font-bold mb-2">{{ $video->title }}</h1>
            <p class="text-sm font-bold">Anda dizinkan menonton dari {{ $video->video_access_req->first()->video_access_time->start_date }} sampai {{ $video->video_access_req->first()->video_access_time->end_date }}</p>
            <p class="text-sm font-light">Diupload pada {{ $video->created_at }}</p>
            <p class="text-sm font-light">{{ $video->description }}</p>
        </div>
    </div>

@endsection
