<div class="px-4 py-20 mx-auto max-w-7xl sm:px-6 sm:py-18 lg:px-8">
 <div class="absolute inset-0 w-full -z-10 h-96 bg-darkBlue/90"></div>


 <div class="pt-2 ">
  <div class="p-2 mx-auto mb-5 text-white  w-fit">
   <p class="font-serif text-5xl tracking-wide lg:text-6xl">Tentang Kami</p>
  </div>
 </div>
 <div x-data="{ activeTab: 'standar_layanan' }" class=" md:flex md:w-full">
  <!-- Sidebar -->

  <div
   class="flex flex-col p-2 mb-4 overflow-y-auto bg-white rounded-lg shadow-lg gap-y-2 md:mr-4 h-fit md:w-3/12 md:mb-0">

   <div @click="activeTab = 'standar_layanan'"
    :class="activeTab === 'standar_layanan' ? 'bg-darkBlue  text-white' :
        'text-black hover:bg-darkBlue hover:text-white'"
    class="flex flex-col p-2 font-semibold leading-6 rounded-md group hover:cursor-pointer">
    <span class="mt-1">Standar Layanan dan Maklumat Pelayanan Informasi Publik</span>
   </div>
   <div @click="activeTab = 'jalur_layanan'"
    :class="activeTab === 'jalur_layanan' ? 'bg-darkBlue  text-white' :
        'text-black hover:bg-darkBlue hover:text-white'"
    class="flex flex-col p-2 font-semibold leading-6 rounded-md group hover:cursor-pointer">
    <span class="mt-1">Jalur dan Waktu Layanan</span>
   </div>
   <div @click="activeTab = 'prosedur_layanan'"
    :class="activeTab === 'prosedur_layanan' ? 'bg-darkBlue  text-white' :
        'text-black hover:bg-darkBlue hover:text-white'"
    class="flex flex-col p-2 font-semibold leading-6 rounded-md group hover:cursor-pointer">
    <span class="mt-1">Prosedur Layanan</span>
   </div>
   <div @click="activeTab = 'prosedur_permohonan'"
    :class="activeTab === 'prosedur_permohonan' ? 'bg-darkBlue  text-white' :
        'text-black hover:bg-darkBlue hover:text-white'"
    class="flex flex-col p-2 font-semibold leading-6 rounded-md group hover:cursor-pointer">
    <span class="mt-1">Prosedur Permohonan Informasi Publik</span>
   </div>
   <div @click="activeTab = 'galeri_pst'"
    :class="activeTab === 'galeri_pst' ? 'bg-darkBlue  text-white' :
        'text-black hover:bg-darkBlue hover:text-white'"
    class="flex flex-col p-2 font-semibold leading-6 rounded-md group hover:cursor-pointer">
    <span class="mt-1">Galeri PST</span>
   </div>
  </div>

  <!-- Content Area -->
  <div class="flex-1">
   <div x-show="activeTab === 'standar_layanan'" class="">
    <div class="p-6 bg-white rounded-lg shadow-lg">
     <p class="mb-2 text-xl font-semibold text-darkBlue">
      Standar Layanan Informasi Publik
     </p>
     <p class="mb-2 text-lg text-gray-800">
      Standar Layanan Informasi Publik yang selanjutnya disebut Standar Layanan merupakan ukuran yang dijadikan pedoman
      dalam memberikan layanan, penyediaan, dan penyampaian Informasi Publik yang didalamnya berisi pedoman mengenai:
     </p>

     <ul class="ml-6 space-y-2 text-lg text-gray-700 list-disc list-inside">
      <li class="hover:text-blue-600">Standar Pengumuman</li>
      <li class="hover:text-blue-600">Standar Permintaan Informasi Publik</li>
      <li class="hover:text-blue-600">Standar Biaya</li>
      <li class="hover:text-blue-600">Standar Pengajuan Keberatan</li>
      <li class="hover:text-blue-600">Standar Penetapan dan Pemutakhiran Daftar Informasi Publik</li>
      <li class="hover:text-blue-600">Standar Pendokumentasian Informasi Publik</li>
      <li class="hover:text-blue-600">Standar Maklumat Pelayanan</li>
      <li class="hover:text-blue-600">Standar Pengujian Konsekuensi</li>
     </ul>

     <div class="my-6 text-gray-900 ">
      <ul role="list" class="space-y-4 text-lg rounded-md">
       <li class="flex items-center justify-between py-6 pl-4 pr-5 leading-6 border-2 border-grey">
        <div class="flex items-center flex-1 w-0">
         <svg class="flex-shrink-0 w-5 h-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd"
           d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z"
           clip-rule="evenodd" />
         </svg>
         <div class="flex flex-1 min-w-0 gap-2 ml-4 ">
          <span class="text-sm font-medium truncate sm:text-base">Standar Layanan Informasi Publik BPS</span>
          <span class="flex-shrink-0 text-sm text-gray-400 sm:text-base">2.88 mb</span>
         </div>
        </div>
        <div class="flex-shrink-0 ml-4 ">
         <a href="{{ asset('dokumen/Standar_Layanan_Informasi_Publik_BPS_1724896378.pdf') }}" class="font-medium text-indigo-600 hover:text-indigo-500">Download</a>
        </div>
       </li>

       <li class="flex items-center justify-between py-6 pl-4 pr-5 leading-6 border-2 border-grey">
        <div class="flex items-center flex-1 w-0">
         <svg class="flex-shrink-0 w-5 h-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd"
           d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z"
           clip-rule="evenodd" />
         </svg>
         <div class="flex flex-1 min-w-0 gap-2 ml-4 ">
          <span class="text-sm font-medium truncate sm:text-base">SK PENETAPAN STANDAR DAN MAKLUMAT PELAYANAN STATISTIK TERPADU</span>
          <span class="flex-shrink-0 text-sm text-gray-400 sm:text-base">672.99 kb</span>
         </div>
        </div>
        <div class="flex-shrink-0 ml-4 ">
         <a href="{{ asset('dokumen/SK_PENETAPAN_STANDAR_DAN_MAKLUMAT_PELAYANAN_STATISTIK_TERPADU_1712288962_2.pdf') }}" class="font-medium text-indigo-600 hover:text-indigo-500">Download</a>
        </div>
       </li>
      </ul>
     </div>

     <div class="mt-2">
      <img src="{{ asset('img/maklumat.webp') }}" alt="" class="">
     </div>

    </div>


   </div>

   <div x-show="activeTab === 'jalur_layanan'" class="">
    <div class="p-6 bg-white rounded-lg shadow-lg">
     <p class="mb-2 text-xl font-semibold text-darkBlue">
      Jalur dan Waktu Layanan
     </p>
     <ul class="mx-6 space-y-2 text-lg text-gray-700 list-decimal list-outside">
      <li class="">Jalur Telepon : (0752) 21251</li>
      <li class="">Jalur Email : bps1375@bps.go.id</li>
      <li class="">Jalur Website : <a href="https://ppid.bps.go.id/"
        class="hover:text-blue-500">https://ppid.bps.go.id/</a> </li>
      <li class="">Jalur Mobile : Allstat Android, Allstats IOS</li>
      <li class="">Ruang Layanan Informasi Publik : Ruang BPS Kota Bukittinggi, Jl. Perwira No.50 Belakang Balok
       Kota Bukittinggi.</li>
     </ul>

     <div class="mt-2">
      <img src="{{ asset('img/jam-layanan.webp') }}" alt="" class="">
     </div>

    </div>


   </div>

   <div x-show="activeTab === 'prosedur_layanan'" class="">
    <div class="p-6 bg-white rounded-lg shadow-lg">
     <p class="mb-2 text-xl font-semibold text-darkBlue">Prosedur Pelayanan</p>
     <p class="mb-2 text-lg text-gray-800">
      Di BPS Bukittinggi terdapat beberapa jenis pelayanan yaitu :
     </p>
     <ul class="mx-6 space-y-2 text-lg text-gray-700 list-decimal list-outside">
      <li>Perpustakaan</li>
      <li>Rekomendasi Statistik</li>
      <li>Penjualan Produk Statistik</li>
      <li>Konsultasi Statistik</li>
     </ul>

     <!-- Carousel -->
     <div class="mt-2" x-data="carousel()" x-init="start()">
      <!-- Carousel wrapper -->
      <div class="relative w-full overflow-hidden rounded-lg">
       <div class="relative " style="aspect-ratio: 16 / 9;">
        <!-- Carousel items -->
        <template x-for="(image, index) in images" :key="index">
         <div x-show="current === index" class="absolute inset-0 transition-transform duration-700 ease-in-out"
          :class="{ 'opacity-0': current !== index }">
          <img :src="image" class="block object-cover w-full h-full" alt="Carousel image">
         </div>
        </template>
       </div>

       <!-- Slider indicators -->
       <div class="absolute z-30 flex space-x-3 transform -translate-x-1/2 bottom-5 left-1/2">
        <template x-for="(image, index) in images" :key="index">
         <button @click="goToSlide(index)" class="w-3 h-3 rounded-full"
          :class="{ 'bg-grey': current !== index, 'bg-darkBlue': current === index }"
          aria-label="Slide indicator"></button>
        </template>
       </div>

       <!-- Slider controls -->
       <button @click="prev"
        class="absolute top-0 left-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none">
        <span
         class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-black/30 group-hover:bg-black/50 group-focus:ring-4 group-focus:ring-white">
         <svg class="w-4 h-4 text-black" fill="none" viewBox="0 0 6 10" xmlns="http://www.w3.org/2000/svg">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
           d="M5 1 1 5l4 4" />
         </svg>
         <span class="sr-only">Previous</span>
        </span>
       </button>
       <button @click="next"
        class="absolute top-0 right-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none">
        <span
         class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-black/30 group-hover:bg-black/50 group-focus:ring-4 group-focus:ring-white">
         <svg class="w-4 h-4 text-black" fill="none" viewBox="0 0 6 10" xmlns="http://www.w3.org/2000/svg">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
           d="M1 9l4-4-4-4" />
         </svg>
         <span class="sr-only">Next</span>
        </span>
       </button>
      </div>
     </div>
    </div>
   </div>

   <div x-show="activeTab === 'prosedur_permohonan'" class="">
    <div class="p-6 bg-white rounded-lg shadow-lg">
     <p class="mb-2 text-xl font-semibold text-darkBlue">Prosedur Permohonan Informasi Publik</p>
     <p class="mb-2 text-lg text-gray-800">
      Mekanisme Permintaan Informasi Publik BPS:
     </p>

     <ul class="mx-6 space-y-2 text-lg text-gray-700 list-decimal list-outside">
      <li>Pemohon Informasi dapat menyampaikan Permintaan Informasi Publik secara online melalui link Permintaan
       Informasi Publik Online atau datang langsung ke Ruang Layanan PPID di Kantor Badan Pusat Statistik Kota
       Bukittinggi Jl. Perwira No.50 Bukittinggi.</li>
      <li>Pemohon Informasi melengkapi persyaratan Permintaan Informasi Publik sesuai dengan Standar Layanan PPID BPS
       Kota Bukittinggi.</li>
      <li>PPID BPS Kota Bukittinggi melakukan pemeriksaan kelengkapan Permintaan Informasi Publik paling lambat 3 (tiga)
       hari sejak Permintaan Informasi Publik telah dicatat dalam buku register Permintaan Informasi Publik.</li>
      <li>Jika persyaratan tidak lengkap, Pemohon Informasi dapat menyerahkan perbaikan Permintaan Informasi Publik
       dalam jangka waktu paling lama 3 (tiga) hari sejak surat keterangan tidak lengkap diterima Pemohon Informasi
       Publik.</li>
      <li>PPID BPS Kota Bukittinggi menyampaikan pemberitahuan tertulis kepada Pemohon Informasi Publik paling lambat 10
       (sepuluh) hari sejak Permintaan Informasi Publik dinyatakan lengkap.</li>
      <li>Dalam hal penolakan Permintaan Informasi Publik berdasarkan alasan pengecualian Informasi, PPID BPS Kota
       Bukittinggi wajib menyampaikan pemberitahuan secara tertulis dan disertai surat keputusan pengecualian informasi.
      </li>
      <li>Dalam hal PPID belum menguasai atau mendokumentasikan Informasi Publik yang diminta; dan/atau belum dapat
       memutuskan status Informasi yang dimohon. PPID BPS memberitahukan perpanjangan waktu yang disertai dengan alasan
       tertulis kepada Pemohon Informasi Publik, paling lambat 7 (tujuh) hari sejak jangka waktu pemberitahuan tertulis
       dan tidak dapat diperpanjang lagi.</li>
     </ul>

     <div class="mt-2">
      <img src="{{ asset('img/alur_permohonan.webp') }}" alt="">
     </div>
    </div>
   </div>

   <div x-show="activeTab === 'galeri_pst'" class="">
    <div class="p-6 bg-white rounded-lg shadow-lg">
     <p class="mb-4 text-2xl font-semibold text-center text-darkBlue sm:text-4xl">Galeri PST</p>
     <div class="grid grid-cols-3 gap-4">
      <div class="col-span-2 row-span-2">
       <img src="{{ asset('img/cta-5.webp') }}" alt="Image 1" class="object-cover w-full h-full rounded-lg">
      </div>
      <div>
       <img src="{{ asset('img/cta-1.webp') }}" alt="Image 2" class="object-cover w-full h-full rounded-lg">
      </div>
      <div>
       <img src="{{ asset('img/cta-2.webp') }}" alt="Image 3" class="object-cover w-full h-full rounded-lg">
      </div>
      <div>
       <img src="{{ asset('img/cta-3.webp') }}" alt="Image 4" class="object-cover w-full h-full rounded-lg">
      </div>
      <div>
       <img src="{{ asset('img/cta-4.webp') }}" alt="Image 5" class="object-cover w-full h-full rounded-lg">
      </div>
      <div>
       <img src="{{ asset('img/cta-5.webp') }}" alt="Image 5" class="object-cover w-full h-full rounded-lg">
      </div>
     </div>
    </div>
   </div>



  </div>
 </div>
</div>

<script>
 function carousel() {
  return {
   current: 0,
   images: [
    '{{ asset('img/layanan-1.webp') }}',
    '{{ asset('img/layanan-2.webp') }}',
    '{{ asset('img/layanan-3.webp') }}',
    '{{ asset('img/layanan-4.webp') }}',
    '{{ asset('img/layanan-5.webp') }}',
    '{{ asset('img/layanan-6.webp') }}',
    '{{ asset('img/layanan-7.webp') }}',
   ],
   start() {
    this.interval = setInterval(() => {
     this.next();
    }, 5000);
   },
   next() {
    this.current = (this.current + 1) % this.images.length;
   },
   prev() {
    this.current = (this.current - 1 + this.images.length) % this.images.length;
   },
   goToSlide(index) {
    this.current = index;
   }
  };
 }
</script>
