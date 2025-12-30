<div x-data="{ pekerjaan: '{{ $pekerjaan }}',
             jenisKelamin: '{{ $jenis_kelamin }}',
              jenisLayanan: '{{ $jenis_layanan ?? '' }}',
               tujuanLainnya: false,
               isFromWA: {{ $this->isFromWhatsApp ? 'true' : 'false' }} 
               }" @pekerjaan-changed.window="pekerjaan = $event.detail; $wire.set('pekerjaan', pekerjaan)"
    @jenis_kelamin-changed.window="jenisKelamin = $event.detail; $wire.set('jenis_kelamin', jenisKelamin)"
    @tujuan_kunjungan-changed.window="tujuanKunjungan = $event.detail;if(tujuanKunjungan.includes('lainnya')) {tujuanLainnya = true;} else {tujuanLainnya = false;}; $wire.set('tujuan_kunjungan', tujuanKunjungan)">

    <!-- ========================= -->
    <!-- BADGE SUMBER TAMU -->
    <!-- ========================= -->
    <div class="mb-6 text-center">
        @if($this->isFromWhatsApp)
        <div
            class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-gradient-to-r from-green-500 to-green-600 text-white shadow-lg">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.76.982.998-3.675-.236-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.9 6.994c-.004 5.45-4.438 9.88-9.888 9.88m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.333.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.333 11.893-11.893 0-3.18-1.24-6.162-3.495-8.411" />
            </svg>
            <span class="font-bold">📱 Akses dari WhatsApp</span>
            <span class="ml-2 text-xs bg-white/20 px-2 py-0.5 rounded-full">Via Link</span>
        </div>
        @else
        <div
            class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                <path
                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z" />
            </svg>
            <span class="font-bold">🌐 Akses Langsung Web</span>
            <span class="ml-2 text-xs bg-white/20 px-2 py-0.5 rounded-full">Langsung</span>
        </div>
        @endif
    </div>

    <div>
        <h2 class="block text-4xl font-bold leading-7 text-grey lg:hidden">Buku Tamu</h2>

        <div
            class="mt-5 space-y-8 border-b lg:mt-0 border-gray-900/10 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:pb-0">
            <form wire:submit.prevent="submit">
                <!-- Nama Lengkap -->
                <div class="pb-3 sm:pb-6">
                    <livewire:components.text-input colorText="text-grey" label="Nama Lengkap" name="nama_lengkap"
                        placeholder="Ade Setiawan" wire:model="nama_lengkap" />
                </div>

                <!-- Jenis Kelamin -->
                <livewire:components.radio-button-input colorText="text-grey" name="jenis_kelamin" label="Jenis Kelamin"
                    :options="['Laki-Laki' => 'Laki-Laki', 'Perempuan' => 'Perempuan']" />

                <!-- Umur -->
                <div class="py-3 sm:py-6">
                    <livewire:components.text-input colorText="text-grey" type="number" label="Usia" name="usia"
                        wire:model="usia" placeholder="25" />
                </div>

                <!-- Pekerjaan -->
                <livewire:components.radio-button-input colorText="text-grey" name="pekerjaan" label="Pekerjaan"
                    :options="[
                        'mahasiswa' => 'Mahasiswa',
                        'dinas/instansi/opd' => 'Dinas/Instansi/OPD',
                        'peneliti' => 'Peneliti',
                        'umum' => 'Umum',
                    ]" />

                <!-- Conditional Inputs -->
                <div x-show="pekerjaan === 'mahasiswa'">
                    <div>
                        <div class="py-3 sm:py-6">
                            <livewire:components.text-input colorText="text-grey" label="Jurusan" name="jurusan"
                                placeholder="Statistika" wire:model="jurusan" />
                        </div>
                        <div class="py-3 sm:py-6">
                            <livewire:components.text-input colorText="text-grey" label="Asal Universitas"
                                name="asal_universitas"
                                placeholder="Universitas Islam Negeri Sjech M. Djamil Djambek Bukittinggi"
                                wire:model="asal_universitas" />
                        </div>
                    </div>
                </div>

                <div x-show="pekerjaan === 'dinas/instansi/opd'">
                    <div class="py-3 sm:py-6">
                        <livewire:components.text-input colorText="text-grey" label="Asal Instansi" name="asal"
                            placeholder="Diskominfo Kota Bukittinggi" wire:model="asal" />
                    </div>
                </div>

                <div x-show="pekerjaan === 'peneliti'">
                    <div class="py-3 sm:py-6">
                        <livewire:components.text-input colorText="text-grey"
                            label="Asal Universitas / Lembaga Penelitian" name="asal_universitas_lembaga"
                            wire:model="asal_universitas_lembaga" placeholder="The SMERU Research Institute" />
                    </div>
                </div>

                <div x-show="pekerjaan === 'umum'">
                    <div class="py-3 sm:py-6">
                        <livewire:components.text-input colorText="text-grey" label="Organisasi/Nama Perusahaan/Kantor"
                            name="organisasi_nama_perusahaan_kantor" wire:model="organisasi_nama_perusahaan_kantor"
                            placeholder="Komunitas Bantuan Sosial" />
                    </div>
                </div>

                {{-- No HP --}}
                <div class="py-3 sm:py-6">
                    <livewire:components.text-input colorText="text-grey" type="tel" label="No HP" name="no_hp"
                        wire:model="no_hp" placeholder="081234567890" pattern="[0-9]*" inputmode="numeric" />
                </div>

                <div class="py-3 sm:py-6">
                    <livewire:components.text-input colorText="text-grey" label="Email" name="email"
                        placeholder="pstbps@gmail.com" type="email" wire:model="email" />
                </div>


                <!-- Jenis Layanan (Hanya Tampil Jika dari WhatsApp) -->
                <div x-show="isFromWA" x-transition>
                    <div class="py-3 sm:py-6">
                        <livewire:components.radio-button-input colorText="text-grey" name="jenis_layanan"
                            label="Jenis Layanan" :options="['pst' => 'PST', 'ppid' => 'PPID']"
                            wire:model="jenis_layanan" />
                    </div>
                </div>

                <!-- Web Langsung: Tidak ada pilihan, hanya info -->
                <!-- <div x-show="!isFromWA" x-transition>
                    <div class="py-3 sm:py-6">
                        <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4">
                            <label class="block text-sm font-bold leading-6 text-white sm:text-lg">
                                Jenis Layanan
                            </label>
                            <div class="mt-2 sm:col-span-2 sm:mt-0">
                                <div class="h-full">
                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                        <p class="text-sm text-blue-800">
                                            Tidak perlu memilih jenis layanan untuk pendaftaran web langsung
                                        </p>
                                        <p class="text-xs text-blue-600 mt-1">
                                            Ingin memilih jenis layanan? Gunakan link WhatsApp.
                                        </p>
                                    </div> -->
                                    <!-- Hidden input untuk NULL value -->
                                    <!-- <input type="hidden" name="jenis_layanan" wire:model="jenis_layanan" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->


                <!-- Pilihan Lainnya (Jika pekerjaan adalah umum, peneliti, dll) -->
                <div class="py-3 sm:py-6">
                    <livewire:components.select-option colorText="text-grey" name="provinsi_id" label="Provinsi"
                        :options="$this->provinces" wire:model.live="provinsi_id"
                        :key="$this->provinces->pluck('id')->join('-')">
                </div>

                <div class="py-3 sm:py-6">
                    <livewire:components.select-option colorText="text-grey" name="kota_id" label="Kota"
                        :options="$this->regencies" wire:model.live="kota_id"
                        :key="$this->regencies->pluck('id')->join('-')">
                </div>

                <div class="py-3 sm:py-6">
                    <livewire:components.text-input colorText="text-grey" type="textarea" rows="4" name="alamat"
                        label="Alamat" wire:model="alamat" placeholder="Jl. Perwira No. 50 Belakang Balok" />
                </div>

                <!-- Tujuan Kunjungan -->
                <div class="py-3 sm:py-6">
                    @livewire(
                    'components.check-box-input',
                    [
                    'name' => 'tujuan_kunjungan',
                    'label' => 'Tujuan Kunjungan',
                    'options' => [
                    'permintaan_data/peta' => 'Permintaan Data/Peta',
                    'konsultasi_statistik' => 'Konsultasi Statistik',
                    'permintaan_data_mikro' => 'Permintaan Data Mikro',
                    'romantik' => 'Romantik',
                    'lainnya' => 'Lainnya',
                    ],
                    'colorText' => 'text-grey',
                    'input' => $tujuan_kunjungan,
                    ],
                    key('checkbox-input')
                    )
                </div>

                <div class="pb-3 sm:pb-6">
                    <div x-show="tujuanLainnya">
                        <livewire:components.text-input colorText="text-grey" type="textarea" rows="4"
                            name="tujuan_kunjungan_lainnya" wire:model="tujuan_kunjungan_lainnya"
                            placeholder="Sebutkan tujuan lainnya" />
                    </div>
                </div>

                <!-- Bukti Identitas Diri -->
                <div class="py-3 sm:py-6">
                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 ">
                        <label for="bukti_identitas_diri_path"
                            class="block text-sm font-bold leading-6 text-white sm:text-lg">
                            Bukti Identitas Diri
                        </label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <div class="h-full">
                                <input
                                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer sm:text-lg bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                    aria-describedby="file_input_help" id="bukti_identitas_diri_path" type="file"
                                    name="bukti_identitas_diri_path" wire:model="bukti_identitas_diri_path">
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG,
                                    JPG atau PDF (MAX.2MB).</p>
                            </div>

                            @error('bukti_identitas_diri_path')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Dokumen Formulir Permintaan Publik -->
                <div class="py-3 sm:py-6">
                    <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 ">
                        <label for="dokumen_permintaan_informasi_publik_path"
                            class="block text-sm font-bold leading-6 text-white sm:text-lg">
                            Dokumen Formulir Permintaan Publik
                        </label>
                        <div class="mt-2 sm:col-span-2 sm:mt-0">
                            <div class="h-full">
                                <input
                                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer sm:text-lg bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                    aria-describedby="file_input_help" id="dokumen_permintaan_informasi_publik_path"
                                    type="file" name="dokumen_permintaan_informasi_publik_path"
                                    wire:model="dokumen_permintaan_informasi_publik_path">
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG,
                                    JPG atau PDF (MAX.2MB).</p>
                            </div>

                            @error('dokumen_permintaan_informasi_publik_path')
                            <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Tombol Submit dengan Warna Berbeda -->
                <div class="flex items-center justify-end mt-6 gap-x-6">
                    <button type="submit" wire:loading.attr="disabled" class="inline-flex items-center justify-center w-full px-4 py-3 text-sm font-bold text-white border border-transparent rounded-lg gap-x-2 sm:text-lg 
                        @if($this->isFromWhatsApp) bg-lightYellow hover:bg-lightYellow/80 focus:bg-green-700
                        @else bg-lightYellow hover:bg-lightYellow/80 focus:bg-lightYellow/80
                        @endif
                        disabled:opacity-50 disabled:pointer-events-none">
                        <span wire:loading.remove>
                            Kirim
                        </span>
                        <span wire:loading>
                            <div role="status">
                                <svg aria-hidden="true" class="inline w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 
                                    @if($this->isFromWhatsApp) fill-green-500
                                    @else fill-green-500
                                    @endif" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                        fill="currentColor" />
                                    <path
                                        d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                        fill="currentFill" />
                                </svg>
                                <span class="sr-only">Loading...</span>
                            </div>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ========================= -->
    <!-- MODAL NOMOR ANTRIAN DENGAN BADGE WEB/WA -->
    <!-- ========================= -->
    @if($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 print-area">
        <div class="relative w-full max-w-xs mx-auto animate-scale-in">
            <div class="bg-white rounded-lg shadow-xl overflow-hidden">

                <!-- ================= HEADER ================= -->
                <div class="px-4 py-3 bg-gradient-to-r 
                @if($this->isFromWhatsApp) from-green-500 to-green-600
                @else from-yellow-500 to-yellow-600
                @endif text-center relative">

                    <!-- Badge Source -->
                    <div class="absolute top-2 right-2">
                        <div class="flex items-center px-2 py-1 bg-white/20 rounded-full">
                            <span class="text-xs font-bold text-white">
                                {{ $this->isFromWhatsApp ? 'WA' : 'WEB' }}
                            </span>
                        </div>
                    </div>

                    <h3 class="text-lg font-bold text-black">
                        Pendaftaran {{ $this->isFromWhatsApp ? 'WhatsApp' : 'Web' }}
                    </h3>
                </div>

                <!-- ================= BODY ================= -->
                <div class="px-4 py-5 text-center">

                    <p class="text-xs text-gray-500 mb-2">
                        {{ $this->isFromWhatsApp ? '📱 NOMOR ANTRIAN WHATSAPP ANDA' : '🌐 NOMOR ANTRIAN WEB ANDA' }}
                    </p>

                    <!-- Nomor Antrian -->
                    <div class="mb-4">
                        <div class="inline-block bg-gray-900 rounded-lg px-4 py-3 border-2
                        {{ $this->isFromWhatsApp ? 'border-green-500' : 'border-yellow-500' }}">
                            <span class="text-4xl font-black
                            {{ $this->isFromWhatsApp ? 'text-yellow-400' : 'text-yellow-400' }}">
                                {{ $nomorAntrian ? sprintf('%03d', $nomorAntrian) : '000' }}
                            </span>
                        </div>
                    </div>

                    <!-- Waktu -->
                    <p class="text-xs text-gray-500 mb-4">
                        ⏰ {{ now()->format('H:i') }} • {{ now()->format('d/m/Y') }}
                    </p>

                    <!-- Info -->
                    <div class="p-2 rounded border text-xs
                    {{ $this->isFromWhatsApp ? 'bg-green-50 border-green-200' : 'bg-yellow-50 border-yellow-200' }}">
                        <p class="text-gray-700">
                            <b>Pendaftaran berhasil!</b><br>
                            Silakan menunggu panggilan petugas
                        </p>
                    </div>
                </div>

                <!-- ================= FOOTER ================= -->
                <div class="px-4 py-3 bg-gray-50 border-t">

                    <!-- Tombol Print -->
                    <button onclick="window.print()" type="button" class="print-hidden w-full py-2.5 mb-2 text-gray-700 font-bold rounded-md 
                    bg-white border border-gray-300 hover:bg-gray-100">
                        ⬇️ Unduh Bukti Pendaftaran
                    </button>

                    <!-- Tombol Kembali -->
                    <button onclick="window.location.href='/'" type="button"
                        class="print-hidden bg-lightYellow w-full py-2.5 text-black  rounded-md 
                    {{ $this->isFromWhatsApp ? 'bg-lightYellow hover:bg-lightYellow/80' : 'bg-yellow-500 hover:bg-yellow-600' }}">
                        Kembali ke Halaman Utama
                    </button>

                    <p class="mt-2 text-center text-[10px] text-gray-400">
                        Sistem Buku Tamu Digital • BPS
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= STYLE ================= -->
    <style>
        .animate-scale-in {
            animation: scale-in 0.2s ease-out;
        }

        @keyframes scale-in {
            0% {
                transform: scale(0.9);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* ========== PRINT ONLY MODAL ========== */
        @media print {
            body * {
                visibility: hidden;
            }

            .print-area,
            .print-area * {
                visibility: visible;
            }

            .print-area {
                position: fixed;
                inset: 0;
                background: white !important;
                padding: 0 !important;
            }

            .print-hidden {
                display: none !important;
            }
        }

    </style>
    @endif


</div>
