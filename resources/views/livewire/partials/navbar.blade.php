<nav class="" x-data="{ open: false }">
    {{-- Primary Navigation Menu --}}
    <div aria-label="Top" class="fixed top-0 left-0 right-0 z-10 bg-darkBlue bg-opacity-90 backdrop-blur-xl backdrop-filter">
        <div class="px-4 mx-auto sm:px-6 lg:px-8 max-w-7xl">
            <div class="flex items-center h-16">
                <!-- Logo -->
                <div class="flex justify-center ml-4 lg:ml-0">
                    <a href="{{ route('home') }}">
                        <div class="flex items-center w-auto gap-2">
                            <img class="h-6" src='{{ asset('img/logo-ppid.webp') }}' alt="Logo PPID" />
                            <img class="h-8" src='{{ asset('img/logo-pst.svg') }}' alt="Logo PST" />
                            <div class="text-white ">
                                <p class="-my-1 text-xs font-semibold sm:-my-2 lg:text-base">Informasi Publik</p>
                                <p class="text-xs font-semibold sm:text-sm">BPS KOTA BUKITTINGGI</p>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="flex items-center ml-auto">
                    <div class="hidden font-semibold lg:flex lg:items-center lg:justify-end gap-x-2">
                        <a href="{{ route('home') }}" class="{{ request()->is('/')? 'bg-grey text-black' : 'text-white' }} py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent hover:bg-grey hover:text-black focus:outline-none focus:bg-gray-100 focus:text-black disabled:opacity-50 disabled:pointer-events-none">
                            Home
                        </a>
                        
                        <div x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" class="relative">
                            <a href="{{ route('guest-book') }}" class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent {{ request()->is('buku-tamu*')? 'bg-grey text-black' : 'text-white' }} hover:bg-grey hover:text-black focus:outline-none focus:bg-gray-100 focus:text-black">
                                Buku Tamu
                                <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </a>
                        
                            <!-- Dropdown -->
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-200" 
                                 x-transition:enter-start="opacity-0 transform scale-95" 
                                 x-transition:enter-end="opacity-100 transform scale-100" 
                                 x-transition:leave="transition ease-in duration-75" 
                                 x-transition:leave-start="opacity-100 transform scale-100" 
                                 x-transition:leave-end="opacity-0 transform scale-95" 
                                 class="absolute right-0 z-20 w-48 mt-2 origin-top-left bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5">
                                <div class="p-1" role="none">
                                    <a href="{{ route('guest-book') }}" class="{{ request()->is('buku-tamu')? 'bg-lightYellow text-black' : 'text-gray-700' }} block px-4 py-2 mb-1 text-sm hover:bg-lightYellow hover:text-black rounded">Layanan Buku Tamu</a>
                                    <a href="{{ route('guest-book.feedback') }}" class="{{ request()->is('buku-tamu/feedback')? 'bg-lightYellow text-black' : 'text-gray-700' }} block px-4 py-2 text-sm hover:bg-lightYellow hover:text-black rounded">Feedback</a>
                                </div>
                            </div>
                        </div>
                        
                        <div x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" class="relative">
                            <a href="{{ route('pengaduan') }}" class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent {{ request()->is('pengaduan*') ? 'bg-grey text-black' : 'text-white' }} hover:bg-grey hover:text-black focus:outline-none focus:bg-gray-100 focus:text-black">
                                Pengaduan
                                <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </a>
                        
                            <!-- Dropdown -->
                            <div x-show="open" 
                                 x-transition:enter="transition ease-out duration-200" 
                                 x-transition:enter-start="opacity-0 transform scale-95" 
                                 x-transition:enter-end="opacity-100 transform scale-100" 
                                 x-transition:leave="transition ease-in duration-75" 
                                 x-transition:leave-start="opacity-100 transform scale-100" 
                                 x-transition:leave-end="opacity-0 transform scale-95" 
                                 class="absolute right-0 z-20 w-48 mt-2 origin-top-left bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5">
                                <div class="p-1" role="none">
                                    <a href="{{ route('pengaduan') }}" class="{{ request()->is('pengaduan')? 'bg-lightYellow text-black' : 'text-gray-700' }} block px-4 py-2 mb-1 text-sm hover:bg-lightYellow hover:text-black rounded">Layanan Pengaduan</a>
                                    <a href="{{ route('pengaduan.feedback') }}" class="{{ request()->is('pengaduan/feedback')? 'bg-lightYellow text-black' : 'text-gray-700' }} block px-4 py-2 text-sm hover:bg-lightYellow hover:text-black rounded">Feedback</a>
                                </div>
                            </div>
                        </div>
                        
                        <a href="{{ route('about-us') }}" class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent {{ request()->is('tentang-kami')? 'bg-grey text-black' : 'text-white' }} hover:bg-grey hover:text-black focus:outline-none focus:bg-gray-100 focus:text-black">
                            Tentang Kami
                        </a>
                        
                        <a href="/user/login" class="inline-flex items-center px-6 py-2 text-sm font-medium text-white border border-transparent rounded-lg bg-lightYellow gap-x-2 hover:bg-lightYellow/95 focus:outline-none focus:bg-lightYellow/95">
                            Login
                        </a>
                    </div>
                </div>

                <!-- Mobile menu button -->
                <button type="button" class="relative p-2 text-gray-400 bg-white rounded-md lg:hidden" @click="open = !open">
                    <span class="absolute -inset-0.5"></span>
                    <span class="sr-only">Open menu</span>
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-40 lg:hidden" 
         role="dialog" 
         aria-modal="true"
         style="display: none;">
        
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-black bg-opacity-25" @click="open = false"></div>
        
        <!-- Mobile menu panel -->
        <div class="fixed inset-y-0 right-0 z-40 w-full max-w-xs overflow-y-auto bg-white shadow-xl">
            <div class="flex flex-col h-full">
                <!-- Close button -->
                <div class="flex items-center justify-between p-4 border-b">
                    <h2 class="text-lg font-medium text-gray-900">Menu</h2>
                    <button type="button" 
                            class="relative p-2 -m-2 text-gray-400 rounded-md"
                            @click="open = false">
                        <span class="absolute -inset-0.5"></span>
                        <span class="sr-only">Close menu</span>
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Navigation links -->
                <div class="flex-1 px-4 py-6 space-y-1">
                    <a href="{{ route('home') }}" 
                       class="flex items-center px-3 py-3 text-base font-medium rounded-lg {{ request()->is('/') ? 'bg-lightYellow text-white' : 'text-gray-900 hover:bg-lightYellow hover:text-white' }}">
                        Beranda
                    </a>

                    <!-- Buku Tamu Dropdown -->
                    <div x-data="{ dropdownOpen: false }" class="space-y-1">
                        <button @click="dropdownOpen = !dropdownOpen"
                                class="flex items-center justify-between w-full px-3 py-3 text-base font-medium rounded-lg {{ request()->is('buku-tamu*') ? 'bg-lightYellow text-white' : 'text-gray-900 hover:bg-lightYellow hover:text-white' }}">
                            <span>Buku Tamu</span>
                            <svg :class="{ 'rotate-180': dropdownOpen }" 
                                 class="w-5 h-5 transition-transform duration-200" 
                                 fill="none" 
                                 viewBox="0 0 24 24" 
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        
                        <div x-show="dropdownOpen" 
                             x-collapse
                             class="pl-4 space-y-1">
                            <a href="{{ route('guest-book') }}"
                               class="flex items-center px-3 py-2 text-sm rounded-lg {{ request()->is('buku-tamu') ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-100' }}">
                                Layanan Buku Tamu
                            </a>
                            <a href="{{ route('guest-book.feedback') }}"
                               class="flex items-center px-3 py-2 text-sm rounded-lg {{ request()->is('buku-tamu/feedback') ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-100' }}">
                                Feedback
                            </a>
                        </div>
                    </div>

                    <!-- Pengaduan Dropdown -->
                    <div x-data="{ dropdownOpen: false }" class="space-y-1">
                        <button @click="dropdownOpen = !dropdownOpen"
                                class="flex items-center justify-between w-full px-3 py-3 text-base font-medium rounded-lg {{ request()->is('pengaduan*') ? 'bg-lightYellow text-white' : 'text-gray-900 hover:bg-lightYellow hover:text-white' }}">
                            <span>Pengaduan</span>
                            <svg :class="{ 'rotate-180': dropdownOpen }" 
                                 class="w-5 h-5 transition-transform duration-200" 
                                 fill="none" 
                                 viewBox="0 0 24 24" 
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        
                        <div x-show="dropdownOpen" 
                             x-collapse
                             class="pl-4 space-y-1">
                            <a href="{{ route('pengaduan') }}"
                               class="flex items-center px-3 py-2 text-sm rounded-lg {{ request()->is('pengaduan') ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-100' }}">
                                Layanan Pengaduan
                            </a>
                            <a href="{{ route('pengaduan.feedback') }}"
                               class="flex items-center px-3 py-2 text-sm rounded-lg {{ request()->is('pengaduan/feedback') ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:bg-gray-100' }}">
                                Feedback
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('about-us') }}" 
                       class="flex items-center px-3 py-3 text-base font-medium rounded-lg {{ request()->is('tentang-kami') ? 'bg-lightYellow text-white' : 'text-gray-900 hover:bg-lightYellow hover:text-white' }}">
                        Tentang Kami
                    </a>
                </div>

                <!-- Login section -->
                <div class="p-4 border-t">
                    <a href="/user/login" 
                       class="flex items-center justify-center w-full px-4 py-3 text-base font-medium text-white rounded-lg bg-lightYellow hover:bg-lightYellow/95">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>