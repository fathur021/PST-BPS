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

        <!-- akses dari wa -->
        <div
            class="inline-flex items-center justify-center gap-3 px-4 py-2 rounded-lg bg-gradient-to-r from-green-500 to-green-600 text-white shadow-lg">

            <i class="fa-brands fa-whatsapp text-lg"></i>
            <span class="font-bold">Akses dari WhatsApp</span>

        </div>
        @else
        <div class="inline-flex items-center justify-center gap-3 px-4 py-2 rounded-lg
bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg">

            <i class="fa-solid fa-globe text-lg"></i>

            <span class="font-bold">Akses Langsung Web</span>

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
                <div class="py-3 sm:py-6 flex flex-col items-center">
                    <div class="w-full max-w-md">
                        <livewire:components.text-input colorText="text-grey" type="tel" label="No HP" name="no_hp"
                            wire:model.live="no_hp" placeholder="081234567890" pattern="[0-9]*" inputmode="numeric" />

                        @error('no_hp')
                        <p class="text-red-500 text-sm mt-1 text-center">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>
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
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 modal-overlay print-area">
        <div class="relative w-full max-w-xs mx-auto animate-scale-in">
            <div class="modal-card">

                <!-- ================= HEADER ================= -->
                <div class="modal-header
                {{ $this->isFromWhatsApp ? 'modal-wa' : 'modal-web' }}">

                    <!-- Badge Source -->
                    <div class="modal-badge">
                        {{ $this->isFromWhatsApp ? 'WA' : 'WEB' }}
                    </div>

                    <h3 class="modal-title">
                        Pendaftaran {{ $this->isFromWhatsApp ? 'WhatsApp' : 'Web' }}
                    </h3>
                </div>

                <!-- ================= BODY ================= -->
                <div class="modal-body">

                    <p class="modal-subtitle flex items-center justify-center gap-2 text-center">
                        @if ($this->isFromWhatsApp)
                        <i class="fa-brands fa-whatsapp"></i>
                        <span>NOMOR ANTRIAN WHATSAPP ANDA</span>
                        @else
                        <i class="fa-solid fa-globe"></i>
                        <span>NOMOR ANTRIAN WEB ANDA</span>
                        @endif
                    </p>

                    <!-- Nomor Antrian -->
                    <div class="queue-wrapper">
                        <div class="queue-box">
                            {{ $nomorAntrian ? sprintf('%03d', $nomorAntrian) : '000' }}
                        </div>
                    </div>

                    <!-- Waktu -->
                    <p class="modal-time">
                        <i class="fa-regular fa-clock"></i>

                        {{ now()->format('H:i') }} • {{ now()->format('d/m/Y') }}
                    </p>

                    <!-- Info -->
                    <div class="modal-info">
                        <b>Pendaftaran berhasil!</b><br>
                        Silakan menunggu panggilan petugas
                    </div>
                </div>

                <!-- ================= FOOTER ================= -->
                <div class="modal-footer">

                    <button onclick="window.print()" type="button" class="btn btn-outline print-hidden flex items-center justify-center gap-2
           text-blue-600 border-blue-600 hover:bg-blue-600 hover:text-white">

                        <i class="fa-solid fa-download"></i>
                        Unduh Bukti Pendaftaran
                    </button>

                    <button onclick="window.location.href='/'" type="button" class="btn btn-primary print-hidden">
                        Kembali ke Halaman Utama
                    </button>

                    <p class="modal-footer-text">
                        Sistem Buku Tamu Digital • BPS
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= FULL CSS ================= -->
    <style>
        /* ================= OVERLAY ================= */
        .modal-overlay {
            background: rgba(15, 23, 42, 0.85);
        }

        /* ================= CARD ================= */
        .modal-card {
            background: #0f172a;
            color: #e5e7eb;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.6);
        }

        /* ================= HEADER ================= */
        .modal-header {
            position: relative;
            padding: 14px;
            text-align: center;
            font-weight: 700;
        }

        .modal-wa {
            background: linear-gradient(135deg, #16a34a, #15803d);
        }

        .modal-web {
            background: linear-gradient(135deg, #facc15, #ca8a04);
            color: #1f2937;
        }

        .modal-title {
            font-size: 15px;
            letter-spacing: 0.05em;
        }

        /* Badge */
        .modal-badge {
            position: absolute;
            top: 8px;
            right: 10px;
            background: rgba(255, 255, 255, 0.25);
            color: white;
            font-size: 11px;
            padding: 2px 8px;
            border-radius: 999px;
        }

        /* ================= BODY ================= */
        .modal-body {
            padding: 18px;
            text-align: center;
        }

        .modal-subtitle {
            font-size: 11px;
            opacity: 0.8;
            margin-bottom: 10px;
        }

        .queue-wrapper {
            margin: 14px 0;
        }

        .queue-box {
            display: inline-block;
            background: #020617;
            border: 2px solid #facc15;
            color: #fde047;
            font-size: 42px;
            font-weight: 900;
            padding: 12px 22px;
            border-radius: 14px;
            letter-spacing: 6px;
            box-shadow: inset 0 0 10px rgba(0, 0, 0, 0.8);
        }

        .modal-time {
            font-size: 11px;
            opacity: 0.75;
            margin-bottom: 14px;
        }

        /* Info */
        .modal-info {
            background: #020617;
            border-left: 4px solid #22c55e;
            padding: 10px;
            font-size: 12px;
            border-radius: 8px;
        }

        /* ================= FOOTER ================= */
        .modal-footer {
            background: #020617;
            padding: 14px;
            text-align: center;
        }

        .modal-footer-text {
            font-size: 10px;
            opacity: 0.5;
            margin-top: 8px;
        }

        /* ================= BUTTON ================= */
        .btn {
            width: 100%;
            padding: 10px;
            border-radius: 10px;
            font-weight: 700;
            margin-bottom: 8px;
            cursor: pointer;
        }

        .btn-primary {
            background: linear-gradient(135deg, #facc15, #ca8a04);
            color: #1f2937;
            border: none;
        }

        .btn-outline {
            background: transparent;
            border: 1px solid #64748b;
            color: #e5e7eb;
        }

        .btn:hover {
            opacity: 0.9;
        }

        /* ================= ANIMATION ================= */
        .animate-scale-in {
            animation: scale-in 0.25s ease-out;
        }

        @keyframes scale-in {
            from {
                transform: scale(0.9);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* ================= PRINT (WARNA DIKUNCI) ================= */
        @media print {
            body * {
                visibility: hidden;
            }

            .print-area,
            .print-area * {
                visibility: visible;

                /* 🔒 PAKSA WARNA TETAP */
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .modal-overlay {
                background: white !important;
            }

            .modal-card {
                box-shadow: none !important;
            }

            .print-hidden {
                display: none !important;
            }
        }

    </style>
    @endif




</div>
