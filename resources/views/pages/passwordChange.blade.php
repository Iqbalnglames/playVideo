@extends('layouts.app')
@section('title', 'Edit Data Customer')

@section('content')

    <div class="bg-white p-6 rounded-2xl shadow-md">
        <h2 class="text-xl font-bold mb-4">Tambah Customer</h2>
        @if (session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @elseif(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @elseif(session('info'))
            <div class="bg-blue-100 text-blue-700 p-3 rounded mb-4">
                {{ session('info') }}
            </div>
        @endif
        <form action="{{ route('profile.password.update', $customer->id) }}"  method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm mb-1">Password Lama</label>
                <input type="password" name="password" class="w-full border p-2 rounded-lg @error('nama') border-red-500 @enderror">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm mb-1">Password baru</label>
                <input type="password" name="new_password" class="w-full border p-2 rounded-lg @error('password') border-red-500 @enderror">
                @error('new_password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm mb-1">Konfirmasi password baru</label>
                <input type="password" name="new_password_confirmation" class="w-full border p-2 rounded-lg">
            </div>

            <div class="flex gap-2">
                <button type="submit"
                    class="flex select-none items-center gap-2 rounded bg-slate-800 py-2.5 px-4 text-sm font-semibold text-white shadow-md shadow-slate-900/10 transition-all hover:shadow-lg hover:shadow-slate-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                    type="button">
                    <i class='bx bx-user-plus'></i>
                    Update Password
                </button>
                <a href="{{ route('profile') }}"
                    class="flex select-none items-center w-fit gap-2 rounded border border-slate-800 py-2.5 px-4 text-sm font-semibold text-slate-800 shadow-md shadow-slate-900/10 transition-all hover:shadow-lg hover:shadow-slate-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                    type="button">
                    <i class='bx bxs-left-arrow'></i>
                    Kembali
                </a>
            </div>
        </form>
    </div>

@endsection
