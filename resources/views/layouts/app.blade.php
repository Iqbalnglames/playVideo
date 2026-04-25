<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Video Access System | @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" />
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

    <div class="flex h-screen">

        <div class="flex-1 flex flex-col">

            <header class="flex w-full items-center justify-between border-b-2 border-gray-200 bg-white p-2">
                <div class="flex items-center space-x-2">
                    <button type="button" id="sideBarBtn" class="text-3xl"><i class="bx bx-menu"></i></button>
                    <div>Video Access System</div>
                </div>

                <div>
                    <button id="profileBtn" type="button" class="cursor-pointer h-9 w-9 overflow-hidden rounded-full">
                        <img src="/profile.png" alt="plchldr.co" />
                    </button>

                    <div id="profileBar"
                        class="absolute hidden opacity-0 duration-200 right-2 z-10 mt-1 w-48 divide-y divide-gray-200 rounded-md border border-gray-200 bg-white shadow-md">
                        <div class="flex items-center space-x-2 p-2">
                            <img src="/profile.png" alt="plchldr.co"
                                class="h-9 w-9 rounded-full" />
                            <div class="font-medium">{{ auth()->user()->name }}</div>
                        </div>

                        <div class="flex flex-col space-y-3 p-2">
                            <a href="{{ route('profile') }}" class="transition text-slate-800 hover:opacity-50">My Profile</a>
                            <a href="{{ route('profile.edit') }}" class="transition text-slate-800 hover:opacity-50">Edit Profile</a>
                        </div>

                        <form action="{{ route('logout') }}" method="POST" class="p-2">
                            @csrf
                            <button type="submit" class="cursor-pointer flex items-center space-x-2 transition hover:text-red-600">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                <div>Log Out</div>
                            </button>
                        </form>
                    </div>
                </div>
            </header>


            <div class="flex h-[90%]">
                <aside id="sidebar"
                    class="flex duration-200 w-72 flex-col space-y-2 border-r-2 border-gray-200 bg-white p-2">
                    <a href="{{ route('video') }}"
                        class="flex items-center space-x-1 rounded-md px-2 py-3 text-slate-800 hover:opacity-50">
                        <span class="text-2xl"><i class="bx bx-home"></i></span>
                        <span>Home</span>
                    </a>

                    @if(auth()->user()->role->role_name == 'admin')
                        <a href="{{ route('video-request') }}"
                            class="flex items-center space-x-1 rounded-md px-2 py-3 text-slate-800 hover:opacity-50">
                            <span class="text-2xl"><i class='bx bxs-file-import'></i></span>
                            <span>Proses Request Video</span>
                        </a>

                        <a href="{{ route('video.list') }}"
                            class="flex items-center space-x-1 rounded-md px-2 py-3 text-slate-800 hover:opacity-50">
                            <span class="text-2xl"><i class='bx bx-upload'></i></span>
                            <span>Upload Video</span>
                        </a>

                        <a href="{{ route('customer') }}"
                            class="flex items-center space-x-1 rounded-md px-2 py-3 text-slate-800 hover:opacity-50">
                            <span class="text-2xl"><i class='bx bx-user-plus'></i></span>
                            <span>Customer</span>
                        </a>
                    @endif
                    <a href="{{ route('profile') }}"
                        class="flex items-center space-x-1 rounded-md px-2 py-3 text-slate-800 hover:opacity-50">
                        <span class="text-2xl"><i class="bx bx-user"></i></span>
                        <span>Profile</span>
                    </a>
                </aside>

                <div class="w-full p-4 overflow-scroll">
                    @yield('content')
                </div>
            </div>

        </div>

    </div>


    <script>
        const sideBarBtn = document.getElementById('sideBarBtn')
        const sidebar = document.getElementById('sidebar')
        const profileBtn = document.getElementById('profileBtn')
        const profileBar = document.getElementById('profileBar')

        function toggleSidebar() {

            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('hidden')
                sidebar.classList.remove('-translate-x-full')
            } else {
                sidebar.classList.add('-translate-x-full')
                setTimeout(() => {
                    sidebar.classList.add('hidden')
                }, 200)
            }
        }

        function toggleProfilebar() {

            if (profileBar.classList.contains('hidden', 'opacity-0')) {
                profileBar.classList.remove('hidden')
                profileBar.classList.remove('opacity-0')
                profileBar.classList.add('opacity-100')
            } else {
                profileBar.classList.add('opacity-0')
                setTimeout(() => {
                    profileBar.classList.add('hidden')
                }, 200)
                profileBar.classList.remove('opacity-100')
            }
        }

        sideBarBtn.addEventListener('click', toggleSidebar)
        profileBtn.addEventListener('click', toggleProfilebar)
    </script>

</body>

</html>
