@extends('layouts.app')
@section('title', 'Data Video')

@section('content')
    <!-- component -->
    <div class="w-300 mx-auto">
        <div class="relative flex flex-col w-full h-full text-slate-700 bg-white shadow-md rounded-xl bg-clip-border">
            <div class="relative mx-4 mt-4 overflow-hidden text-slate-700 bg-white rounded-none bg-clip-border">
                <div class="flex items-center justify-between ">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800">Data Video</h3>
                        <p class="text-slate-500">Edit atau tambah video</p>
                    </div>
                    <div class="flex flex-col gap-2 shrink-0 sm:flex-row">
                        <a href="{{ route('video.upload') }}"
                            class="flex select-none items-center gap-2 rounded bg-slate-800 py-2.5 px-4 text-sm font-semibold text-white shadow-md shadow-slate-900/10 transition-all hover:shadow-lg hover:shadow-slate-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                            type="button">
                            <i class='bx bx-cloud-upload'></i>
                            Upload Video
                        </a>
                    </div>
                </div>

            </div>
            <div class="p-0 overflow-scroll">
                <table class="w-full mt-4 text-left table-auto min-w-max">
                    <thead>
                        <tr>
                            <th
                                class="p-4 transition-colors cursor-pointer border-y border-slate-200 bg-slate-50 hover:bg-slate-100">
                                <p
                                    class="flex items-center justify-between gap-2 font-sans text-sm font-normal leading-none text-slate-500">
                                    Title
                                </p>
                            </th>
                            <th
                                class="p-4 transition-colors cursor-pointer border-y border-slate-200 bg-slate-50 hover:bg-slate-100">
                                <p
                                    class="flex items-center justify-between gap-2 font-sans text-sm  font-normal leading-none text-slate-500">
                                    Dibuat
                                </p>
                            </th>
                            <th
                                class="p-4 transition-colors cursor-pointer border-y border-slate-200 bg-slate-50 hover:bg-slate-100">
                                <p
                                    class="flex items-center justify-between gap-2 font-sans text-sm  font-normal leading-none text-slate-500">
                                    Aksi
                                </p>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($video as $v)
                            <tr>
                            <td class="p-4 border-b border-slate-200">
                                <div class="flex items-center gap-3">
                                    <img src="/storage/{{ $v->thumbnail }}"
                                        alt="{{ $v->title }}"
                                        class="relative inline-block rounded-lg w-30 object-cover object-center" />
                                    <div class="flex flex-col">
                                        <p class="text-sm font-semibold text-slate-700">
                                            {{ $v->title }}
                                        </p>
                                        <p class="text-sm text-slate-500">
                                            {{ $v->description }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 border-b border-slate-200">
                                <p class="text-sm text-slate-500">
                                    {{ $v->created_at->format('d/m/Y') }}
                                </p>
                            </td>
                            <td class="p-4 border-b border-slate-200">
                                    <div class="flex">
                                        <a href="{{ route('video.edit', $v->id) }}"
                                            class="relative h-10 max-h-10 w-10 max-w-10 py-1 px-5 select-none rounded-lg text-center align-middle font-sans text-2xl font-medium uppercase text-slate-900 transition-all hover:bg-slate-900/10 active:bg-slate-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                            type="button">
                                            <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                                                <i class='bx bxs-message-square-edit'></i>
                                            </span>
                                        </a>
                                        <form action="{{ route('video.delete', $v->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="relative h-10 max-h-10 w-10 max-w-10 select-none rounded-lg text-center align-middle font-sans text-2xl font-medium uppercase text-slate-900 transition-all hover:bg-slate-900/10 active:bg-slate-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                                type="button">
                                                <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                                                    <i class='bx bxs-message-square-x'></i>
                                                </span>
                                            </button>
                                        </form>
                                    </div>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">
                                    Tidak ada Data
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="flex items-center justify-between p-3">
                {{ $video->links() }}
            </div>
        </div>
    </div>
@endsection
