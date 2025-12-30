<div x-data="{ show: false }" x-init="show = true" class="relative flex items-center h-screen bg-lightBlue">
    <div aria-hidden="true" class="absolute inset-0 overflow-hidden blur-lg">
        <img src="{{ asset('img/cover-gedung.webp') }}" alt="" class="object-cover object-center w-full h-full">
    </div>
    <div aria-hidden="true" class="absolute inset-0 opacity-50 bg-lightBlue"></div>

    <div x-show="show" class="relative flex flex-col items-center max-w-3xl px-6 py-32 mx-auto text-center sm:py-64 lg:px-0">
        <!-- First Title -->
        <h1 class="text-4xl font-bold text-lightYellow md:text-nowrap lg:text-6xl" 
            x-show="show" 
            x-transition:enter="transition ease-out duration-700 delay-100" 
            x-transition:enter-start="opacity-0 -translate-x-10" 
            x-transition:enter-end="opacity-100 translate-x-0">
            Informasi Publik
        </h1>

        <!-- Second Title -->
        <h1 class="pt-2 text-2xl font-bold text-grey md:text-nowrap lg:text-4xl" 
            x-show="show" 
            x-transition:enter="transition ease-out duration-700 delay-300" 
            x-transition:enter-start="opacity-0 -translate-x-10" 
            x-transition:enter-end="opacity-100 translate-x-0">
            BPS KOTA BUKITTINGGI
        </h1>

        <!-- Description -->
        <div class="mt-4"
            x-show="show" 
            x-transition:enter="transition ease-out duration-700 delay-500" 
            x-transition:enter-start="opacity-0 -translate-x-10" 
            x-transition:enter-end="opacity-100 translate-x-0">
            <div class="max-w-xl">
                <p class="text-white lg:text-lg">Selamat datang di Informasi Publik BPS Kota Bukittinggi.</p>
                <p class="text-white lg:text-lg">Di website ini Anda dapat menemukan berbagai layanan yang kami sediakan dan informasi kontak yang dapat dihubungi.</p>
            </div>
        </div>

        <!-- Button -->
        <div class="mt-6"
            x-show="show" 
            x-transition:enter="transition ease-out duration-500 delay-700" 
            x-transition:enter-start="opacity-0 -translate-x-10" 
            x-transition:enter-end="opacity-100 translate-x-0">
            <a href="/buku-tamu" class="inline-flex items-center px-8 py-2 text-lg font-medium text-black border border-transparent rounded-lg md:py-3 md:px-10 bg-lightYellow gap-x-2 md:text-xl hover:bg-lightYellow/95 focus:outline-none focus:bg-lightYellow/95 disabled:opacity-50 disabled:pointer-events-none dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                Isi Buku Tamu
            </a>
        </div>
    </div>
</div>
