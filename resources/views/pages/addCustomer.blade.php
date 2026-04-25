@extends('layouts.app')
@section('title', 'Tambah Customer')

@section('content')
<a href="{{ route('customer') }}" class="text-blue-500 hover:text-blue-700">← Kembali</a>
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
        @endif
        <form action="{{ route('customer.store') }}"  method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm mb-1">Nama</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border p-2 rounded-lg @error('nama') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm mb-1">Username</label>
                <input type="text" name="username" value="{{ old('username') }}" class="w-full border p-2 rounded-lg @error('username') border-red-500 @enderror">
                @error('username')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border p-2 rounded-lg @error('email') border-red-500 @enderror">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm mb-1">Password</label>
                <input type="password" name="password" class="w-full border p-2 rounded-lg @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm mb-1">Konfirmasi password</label>
                <input type="password" name="password_confirmation" class="w-full border p-2 rounded-lg">
            </div>

            <div class="flex gap-2">
                <button type="submit"
                    class="flex select-none items-center gap-2 rounded bg-slate-800 py-2.5 px-4 text-sm font-semibold text-white shadow-md shadow-slate-900/10 transition-all hover:shadow-lg hover:shadow-slate-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
                    <i class='bx bx-user-plus'></i>
                    Simpan Customer
                </button>
                <a href="{{ route('customer') }}"
                    class="flex select-none items-center w-fit gap-2 rounded border border-slate-800 py-2.5 px-4 text-sm font-semibold text-slate-800 shadow-md shadow-slate-900/10 transition-all hover:shadow-lg hover:shadow-slate-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                    type="button">
                    <i class='bx bxs-left-arrow'></i>
                    Kembali
                </a>
            </div>
        </form>
    </div>

@endsection
