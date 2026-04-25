@extends('layouts.app')
@section('title', 'Home')

@section('content')
    @if (session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @elseif(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    <div class="bg-white p-6 rounded-2xl flex flex-col gap-2 shadow-md">
        <h1 class="text-lg font-semibold text-slate-800">Video yang tersedia</h1>
        @forelse ($video as $v)
            <a href="video/{{ $v->id }}" class="flex  gap-2 hover:bg-slate-200 p-2 hover:rounded-xl">
                <div class="h-30 w-60 bg-gray-500 rounded-xl overflow-hidden">
                    <img src="/storage/{{ $v->thumbnail }}" alt="thumbnail {{ $v->title }}">
                </div>
                <div>
                    <h1 class="font-bold text-lg">{{ $v->title }}</h1>
                    <p class="text-slate-600 font-light">{{ $v->description }}</p>
                    @if(auth()->user()->role->role_name == 'admin')
                        {{ null }}
                    @elseif (!isset($videoReqExist[$v->id]))
                        <form action="{{ route('video-request-access', $v->id) }}" method="POST">
                            @csrf
                            <button class="cursor-pointer text-blue-500 hover:text-blue-700 font-light">Request akses
                                video</button>
                        </form>
                    @else
                        <span
                            class="{{ $videoReqExist[$v->id]->status == 'diizinkan' ? 'text-green-700' : ($videoReqExist[$v->id]->status == 'menunggu persetujuan' ? 'text-yellow-700' : 'text-red-700') }} font-light">
                            {{ $videoReqExist[$v->id]->status }}
                            @if ($videoReqExist[$v->id]->video_access_time->start_date)
                                dari {{ $videoReqExist[$v->id]->video_access_time->start_date }} sampai
                                {{ $videoReqExist[$v->id]->video_access_time->start_date }}
                            @endif
                        </span>
                    @endif
                </div>
            </a>
        @empty
            <p class="text-slate-600 font-bold text-center">Tidak ada video</p>
        @endforelse
        <div>
            {{ $video->links() }}
        </div>
    </div>
@endsection
