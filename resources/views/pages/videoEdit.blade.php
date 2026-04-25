@extends('layouts.app')
@section('title', 'Edit Detail Video')

@section('content')

    <a href="{{ route('video.list') }}" class="text-blue-500 hover:text-blue-700">← Kembali</a>
    <div class="bg-white p-6 rounded-2xl shadow-md">
        <h2 class="text-xl font-bold mb-4">Edit Detail Video</h2>
        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @elseif(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('video.update', $video->id) }}" enctype="multipart/form-data" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm mb-1">Judul</label>
                <input type="text" name="title" value="{{ $video->title }}" class="w-full border p-2 rounded-lg">
            </div>

            <div>
                <label class="block text-sm mb-1">Thumbnail</label>
                <img id="previewThumbnail" src="/storage/{{ $video->thumbnail }}" class="w-60 mb-1 rounded-lg mb-2">
                <input id="thumbnailInput" type="file" accept="image/*" name="thumbnail" class="w-full border p-2 rounded-lg">
            </div>

            <div>
                <label class="block text-sm mb-1">File Video</label>
                <video id="previewVideo" width="500" class="rounded-xl mb-2" controls>
                    <source src="/storage/{{ $video->video_path }}">
                </video>
                <input id="videoInput" type="file" accept="video/*" name="video" class="w-full border p-2 rounded-lg">
            </div>

            <div>
                <label class="block text-sm mb-1">Deskripsi</label>
                <textarea name="description" class="w-full border p-2 rounded-lg">{{ $video->description }}</textarea>
            </div>

            <button
                class="flex select-none items-center gap-2 rounded bg-slate-800 py-2.5 px-4 text-sm font-semibold text-white shadow-md shadow-slate-900/10 transition-all hover:shadow-lg hover:shadow-slate-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                type="submit">
                <i class='bx bx-cloud-upload'></i>
                Upload Video
            </button>
        </form>
    </div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const previewVideo = document.getElementById('previewVideo')
        const videoInput = document.getElementById('videoInput')
        const oldVideo = previewVideo.src
        const previewThumbnail = document.getElementById('previewThumbnail')
        const thumbnailInput = document.getElementById('thumbnailInput')
        const oldThumbnail = previewThumbnail.src

        videoInput.addEventListener('change', (e) => {
            const file = e.target.files[0]

            if(file) {
                previewVideo.src = URL.createObjectURL(file)
            } else {
                previewVideo.src = oldVideo
            }
        })

        thumbnailInput.addEventListener('change', (e) => {
            const file = e.target.files[0]

            if(file) {
                previewThumbnail.src = URL.createObjectURL(file)
            } else {
                previewThumbnail.src = oldThumbnail
            }
        })


    })
</script>
@endsection
