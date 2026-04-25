@extends('layouts.app')
@section('title', 'Request Video Customer')

@section('content')
    <div class="w-300 mx-auto">
        <div class="relative flex flex-col w-full h-full text-slate-700 bg-white shadow-md rounded-xl bg-clip-border">
            <div class="relative mx-4 mt-4 overflow-hidden text-slate-700 bg-white rounded-none bg-clip-border">
                <div class="flex items-center justify-between ">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800">Video Request</h3>
                        <p class="text-slate-500">Review setiap customer sebelum memberi akses</p>
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
                                    Customer
                                </p>
                            </th>
                            <th
                                class="p-4 transition-colors cursor-pointer border-y border-slate-200 bg-slate-50 hover:bg-slate-100">
                                <p
                                    class="flex items-center justify-between font-sans text-sm font-normal leading-none text-slate-500">
                                    Video yang direquest
                                </p>
                            </th>
                            <th
                                class="p-4 transition-colors cursor-pointer border-y border-slate-200 bg-slate-50 hover:bg-slate-100">
                                <p
                                    class="flex items-center justify-between gap-2 font-sans text-sm  font-normal leading-none text-slate-500">
                                    Status
                                </p>
                            </th>
                            <th
                                class="p-4 transition-colors cursor-pointer border-y border-slate-200 bg-slate-50 hover:bg-slate-100">
                                <p
                                    class="flex items-center justify-between gap-2 font-sans text-sm  font-normal leading-none text-slate-500">
                                    Tanggal Request
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
                        @forelse ($videoReq as $vr)
                            <tr>
                                <td class="p-4 border-b border-slate-200">
                                    <div class="flex items-center gap-3">
                                        <div class="flex flex-col">
                                            <p class="text-sm font-semibold text-slate-700">
                                                {{ $vr->user->name }}
                                            </p>
                                            <p class="text-sm text-slate-500">
                                                {{ $vr->user->email }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 border-b border-slate-200">
                                    <div class="flex flex-col">
                                        <p class="text-sm font-semibold text-slate-700">
                                            {{ $vr->video->title }}
                                        </p>
                                    </div>
                                </td>
                                <td class="p-4 border-b border-slate-200">
                                    <div class="w-max">
                                        <div
                                            class="relative grid items-center px-2 py-1 font-sans text-xs font-bold
                                        {{ [
                                            'menunggu persetujuan' => 'text-yellow-900 bg-yellow-500/20',
                                            'diizinkan' => 'text-green-900 bg-green-500/20',
                                            'ditolak' => 'text-red-900 bg-red-500/20',
                                        ][$vr->status] ?? '' }}  uppercase rounded-md select-none whitespace-nowrap">
                                            <span class="">{{ $vr->status }}
                                                @if($vr->video_access_time->start_date)
                                                dari {{ $vr->video_access_time->start_date }} sampai {{ $vr->video_access_time->end_date }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4 border-b border-slate-200">
                                    <p class="text-sm text-slate-500">
                                        {{ $vr->created_at->format('d/m/Y') }}
                                    </p>
                                </td>
                                <td class="p-4 border-b border-slate-200">
                                    <form action="{{ route('approve-request-access', $vr->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button
                                            class="approveBtn relative h-10 max-h-10 w-10 max-w-10 select-none rounded-lg text-center align-middle font-sans text-2xl font-medium uppercase text-slate-900 transition-all hover:bg-slate-900/10 active:bg-slate-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                            type="button">
                                            <span
                                                class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                                                <i class='bx bxs-message-square-check'></i>
                                            </span>
                                        </button>
                                        <div class="overlay hidden h-screen w-screen bg-black opacity-50 fixed inset-0">
                                        </div>
                                        <div
                                            class="durationPopUp w-72 hidden h-fit fixed left-[43%] top-[35%] z-20 mx-auto rounded bg-white p-4 shadow-2xl flex flex-col gap-2">
                                            <i class='closeBtn bx bx-x absolute cursor-pointer text-3xl right-2 top-4'></i>
                                            <h1 class="font-bold">Berikan izin video</h1>
                                            <div class="flex flex-col">
                                                <label for="date">Tanggal mulai</label>
                                                <input type="date" name="start_date"
                                                    class="p-2 rounded-lg border border-slate-900">
                                            </div>
                                            <div class="flex flex-col">
                                                <label for="date">Tanggal selesai</label>
                                                <input type="date" name="end_date"
                                                    class="p-2 rounded-lg border border-slate-900">
                                            </div>
                                            <button type="submit"
                                                class="flex select-none items-center gap-2 rounded bg-slate-800 py-2.5 px-4 text-sm font-semibold text-white shadow-md shadow-slate-900/10 transition-all hover:shadow-lg hover:shadow-slate-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                                type="button">
                                                <i class='bx bx-user-check'></i>
                                                Izinkan
                                            </button>
                                        </div>
                                    </form>
                                    <form action="{{ route('deny-request-access', $vr->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button
                                            class="relative h-10 max-h-10 w-10 max-w-10 select-none rounded-lg text-center align-middle font-sans text-2xl font-medium uppercase text-slate-900 transition-all hover:bg-slate-900/10 active:bg-slate-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                            type="submit">
                                            <span
                                                class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                                                <i class='bx bxs-message-square-x'></i>
                                            </span>
                                        </button>
                                    </form>
                                </td>
                            @empty
                                <td colspan="4" class="text-center">
                                    tidak ada request video
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
            <div class="flex items-center justify-between p-3">
                {{ $videoReq->links() }}
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const approveBtn = document.querySelectorAll('.approveBtn')

            approveBtn.forEach((btn) => {
                btn.addEventListener('click', () => {
                    const parent = btn.closest('form')

                    const overlay = parent.querySelector('.overlay')
                    const durationPopUp = parent.querySelector('.durationPopUp')
                    const closeBtn = parent.querySelector('.closeBtn')
                    if (durationPopUp.classList.contains('hidden')) {
                        durationPopUp.classList.remove('hidden')
                        overlay.classList.remove('hidden')
                    }

                    closeBtn.addEventListener('click', () => {
                        durationPopUp.classList.add('hidden')
                        overlay.classList.add('hidden')
                    })
                })
            })

        })
    </script>
@endsection
