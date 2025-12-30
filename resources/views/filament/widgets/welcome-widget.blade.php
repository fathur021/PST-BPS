<div class="dark:bg-gray-900 bg-white shadow rounded-xl">
  <div class="mx-auto max-w-7xl lg:px-14 px-8">
   <div class="md:py-8 py-4 xl:flex xl:items-center xl:justify-between ">
    <div class="min-w-0 flex-1">
     <div class="flex items-center space-x-3"> <!-- Menggunakan flex dan memberikan space antara elemen -->
       <!-- Bagian gambar profil -->
       <div>
         <img class="rounded-xl object-fill h-32 w-32"
          src="{{ auth()->user()->avatar_url ? Storage::url(auth()->user()->avatar_url) : asset('img/logo-pst.svg') }}"
          alt="User Avatar">
       </div>
 
       <!-- Bagian informasi pengguna -->
       <div class="xl:pt-0 pt-4">
         <div class="ml-3"> 
           <h1 class="text-xl font-bold leading-7 capitalize text-green-400">Selamat datang</h1>
           <h1 class=" text-2xl font-bold leading-7 capitalize">{{ Str::limit($name, 15) }}</h1>
           <h1 class="uppercase text-green-400"> {{ $role }}</h1>
         </div>
       </div>
     </div>
    </div>
 
    @if (auth()->user()->hasRole('pst'))
     <div class="pt-6 flex justify-center space-x-3 md:ml-4 md:mt-0">
      <p class="inline-flex items-center text-center justify-center w-1/2 rounded-md dark:text-green-400 px-3 py-2 md:text-sm text-xs font-semibold shadow-sm ring-1 ring-inset ring-gray-300">
       Total kunjungan yang ditangani : {{ $doneGuestBooks }}
      </p>
      <p class="inline-flex items-center w-1/2 text-center justify-center rounded-md dark:text-green-400 px-3 py-2 md:text-sm text-xs font-semibold shadow-sm ring-1 ring-inset ring-gray-300">
       Rating : {{ $feedbackRating }} / 5
      </p>
     </div>
    @endif
   </div>
  </div>
 </div>
 