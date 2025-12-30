<div class="max-w-7xl mx-auto p-8 mt-16">
 @livewire('partials.svg-background')
 

 <div class=" shadow-lg rounded-lg bg-white">

  <div class="text-4xl lg:m-5 pt-5 mx-5">
   <div class="flex items-center justify-between">
    <div class="flex items-center">
     <div class="mr-16 ">
      <img class="lg:h-10 h-6" src='{{ asset('img/logo-ppid.webp') }}' alt="Logo PPID" />
     </div>
     <div class="md:block hidden">
      <div class=" border-l-2 border-black ">
       <div class="pl-4 text-sm ">
        <p>Pejabat Pengelola Informasi dan Dokumentasi</p>
        <p>Badan Pusat Statistik</p>
       </div>
      </div>
     </div>

    </div>

    <img class="lg:h-20 h-10" src='{{ asset('img/hak-anda-untuk-tahu.webp') }}' alt="Logo PPID" />

   </div>
   <div class="lg:text-4xl text-2xl tracking-wide font-serif text-center mb-5 ">
    <h3 class="">Formulir</h3>
    <h3 class="">Pengajuan Informasi Publik</h3>
   </div>

   <div class="bg-lightYellow/50 p-4 text-white border-l-4 border-yellow-400 bg-yellow-50">
    <div class="flex">
     <div class="flex-shrink-0">
      <svg class="h-7 w-7 text-orange-400 text-xl" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
       <path fill-rule="evenodd"
        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z"
        clip-rule="evenodd" />
      </svg>
     </div>
     <div class="ml-3">
      <h3 class="lg:text-xl text-sm font-bold text-lightYellow">INFO</h3>
      <div class="lg:text-lg text-sm text-black">
       <p>Formulir ini digunakan untuk registrasi pemohon, agar pemohon mendapatkan kemudahan dalam mengajukan
        permohonan informasi maupun pengajuan keberatan secara online. Pemohon dinyatakan berhasil mendaftar apabila
        telah memenuhi semua kelengkapan yang dibutuhkan dan mendapatkan email konfirmasi dari admin e-PPID.</p>
      </div>
     </div>
    </div>
   </div>
  </div>

  <div class="relative flex w-full mx-auto  mb-10">
   <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 400)" x-show="show"
    x-transition:enter="transition transform ease-out duration-500"
    x-transition:enter-start="opacity-0 translate-x-[-20px]" x-transition:enter-end="opacity-100 translate-x-0"
    :class="{ 'invisible': !show, 'relative': show, 'absolute': !show }"
    class="md:mx-6 pb-14 w-full lg:rounded-xl md:p-5 px-5">
    <div class="md:px-4" x-data="{ show: false }" x-init="setTimeout(() => show = true, 800)" x-show="show"
     x-transition:enter="transition transform ease-out duration-500"
     x-transition:enter-start="opacity-0 translate-x-[-20px]" x-transition:enter-end="opacity-100 translate-x-0"
     :class="{ 'invisible': !show, 'relative': show, 'absolute': !show }">
     @livewire('pengaduan.form-pengaduan')
    </div>
   </div>
  </div>
 </div>

 <div x-data='{show: false}' x-show= 'show' :class="{ 'hidden': !show }" x-on:open-modal.window = "show = true"
 x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 "
 x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
 x-transition:leave-start="opacity-100 " x-transition:leave-end="opacity-0 " class="hidden">
   @livewire('pengaduan.modal-success')
 </div>
</div>
