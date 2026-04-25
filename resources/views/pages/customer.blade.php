@extends('layouts.app')
@section('title', 'Data Customer')

@section('content')
    <!-- component -->
    <div class="w-300 mx-auto">
        <div class="relative flex flex-col w-full h-full text-slate-700 bg-white shadow-md rounded-xl bg-clip-border">
            <div class="relative mx-4 mt-4 overflow-hidden text-slate-700 bg-white rounded-none bg-clip-border">
                <div class="flex items-center justify-between ">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-800">Customer</h3>
                        <p class="text-slate-500">Edit atau tambah customer</p>
                    </div>
                    <div class="flex flex-col gap-2 shrink-0 sm:flex-row">
                        <a href="{{ route('customer.create') }}"
                            class="flex select-none items-center gap-2 rounded bg-slate-800 py-2.5 px-4 text-xs font-semibold text-white shadow-md shadow-slate-900/10 transition-all hover:shadow-lg hover:shadow-slate-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                            type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                aria-hidden="true" stroke-width="2" class="w-4 h-4">
                                <path
                                    d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z">
                                </path>
                            </svg>
                            Add Customer
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
                                    Customer
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
                        @forelse ($customer as $c)
                            <tr>
                            <td class="p-4 border-b border-slate-200">
                                <div class="flex items-center gap-3">
                                    <img src="/profile.png"
                                        alt="{{ $c->name }}"
                                        class="relative inline-block h-9 w-9 rounded-full! object-cover object-center" />
                                    <div class="flex flex-col">
                                        <p class="text-sm font-semibold text-slate-700">
                                            {{ $c->name }}
                                        </p>
                                        <p class="text-sm text-slate-500">
                                            {{ $c->email }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 border-b border-slate-200">
                                <p class="text-sm text-slate-500">
                                    {{ $c->created_at->format('d/m/Y') }}
                                </p>
                            </td>
                            <td class="p-4 border-b border-slate-200">
                                    <div class="flex">
                                        <a href="{{ route('customer.edit', $c->id) }}"
                                            class="relative h-10 max-h-10 w-10 max-w-10 py-1 px-5 select-none rounded-lg text-center align-middle font-sans text-2xl font-medium uppercase text-slate-900 transition-all hover:bg-slate-900/10 active:bg-slate-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                            type="button">
                                            <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                                                <i class='bx bxs-message-square-edit'></i>
                                            </span>
                                        </a>
                                        <form action="{{ route('customer.delete', $c->id) }}" method="POST">
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

            </div>
        </div>
    </div>
@endsection
