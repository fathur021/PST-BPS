

  <div class="bg-white shadow p-6 rounded-3xl dark:bg-gray-900">
    <div class="mx-auto max-w-7xl md:px-6">
        <h2 class="md:text-3xl text-xl font-bold leading-6 text-center pb-4">Petugas Pelayanan Terbaik</h2>
  
        <!-- Gunakan grid untuk menampilkan dua div berdampingan -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 p-2">
            <!-- Card 1 -->
            <div class="dark:bg-gray-800 p-4 rounded-lg shadow-md text-center ">
              <h2 class=" xl:text-2xl text-xl font-semibold text-cyan-400">Petugas PST Terbaik</h2>
              <div class="flex items-center  justify-evenly mx-auto text-wrap p-4 ">
                <div class="h-fit w-2/5">
                  <img class="rounded-xl h-full w-full object-center"
                    src="{{ isset($topPetugasPST) && isset($topPetugasPST->avatar_url) ? Storage::url($topPetugasPST->avatar_url) : asset('img/logo-pst.svg') }}"
                    alt="User Avatar">
                </div>
                <div class="px-2 w-3/5">
                  <div class="font-bold pb-2 text-wrap md:text-2xl">{{ $topPetugasPST ? $topPetugasPST->name : 'Tidak ada data' }}</div>
                  <div class="flex items-center justify-center text-cyan-400">
                      <span>Rating : {{ $topPetugasPST ? number_format($ratingTopPST->average_kepuasan,2) : 0 }}/5.00</span>
                  </div>
                </div>
              </div>
            </div>
  
            <div class="dark:bg-gray-800 p-4 rounded-lg shadow-md text-center">
              <h2 class="xl:text-2xl text-xl font-semibold text-green-400">Petugas Front Office Terbaik</h2>
              <div class="flex items-center justify-evenly text-wrap p-4">
                <div class="h-fit w-2/5">
                  <img class="rounded-xl h-full w-full object-center"
                    src="{{ isset($topFrontOffice->avatar_url) && isset($topFrontOffice) ? Storage::url($topFrontOffice->avatar_url) : asset('img/logo-pst.svg') }}"
                    alt="User Avatar">
                </div>
                <div class="px-2 w-3/5">
                  <div class="font-bold pb-2 text-wrap md:text-2xl">{{$topFrontOffice ? $topFrontOffice->name : 'Tidak ada data' }}</div>
                  <div class="flex items-center justify-center text-green-400">
                    <span>Rating : {{ $topFrontOffice ? number_format($ratingTopFrontOffice->average_kepuasan,2) : 0  }}/5.00</span>
                  </div>
                </div>
              </div>
            </div>
  
        </div>
    </div>
  </div>

