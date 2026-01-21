<div 
    x-data="{
        pekerjaan: '{{ $pekerjaan }}',
        jenisKelamin: '{{ $jenis_kelamin }}',
        tujuanLainnya: false,
        isFromWA: {{ $this->isFromWhatsApp ? 'true' : 'false' }}
    }"

    @pekerjaan-changed.window="
        pekerjaan = $event.detail;
        $nextTick(() => {
            $wire.set('pekerjaan', pekerjaan);
        });
    "

    @jenis_kelamin-changed.window="
        jenisKelamin = $event.detail;
        $nextTick(() => {
            $wire.set('jenis_kelamin', jenisKelamin);
        });
    "

    @tujuan_kunjungan-changed.window="
        tujuanKunjungan = $event.detail;

        if (tujuanKunjungan.includes('lainnya')) {
            tujuanLainnya = true;
        } else {
            tujuanLainnya = false;
        }

        $nextTick(() => {
            $wire.set('tujuan_kunjungan', tujuanKunjungan);
        });
    "
>

    <!-- ========================= -->
    <!-- BADGE SUMBER TAMU -->
    <!-- ========================= -->
    <div class="mb-6 text-center">
        @if($this->isFromWhatsApp)
        <!-- akses dari wa -->
        <div class="text-center mb-6">
    <div class="inline-flex items-center justify-center gap-3">
        <i class="fa-brands fa-whatsapp text-lg text-white"></i>
        <span class="font-bold text-lg text-white">Form Identitas Pengunjung Online</span>
    </div>
</div>
        @else
        <div class="text-center mb-6">
    <div class="inline-flex items-center justify-center gap-3">
        <i class="fa-brands fa-whatsapp text-lg text-white"></i>
        <span class="font-bold text-lg text-white">Form Identitas Pengunjung Langsung</span>
    </div>
</div>
        @endif
    </div>

    <div>
        <h2 class="block text-4xl font-bold leading-7 text-grey lg:hidden">Buku Tamu</h2>

        <div
            class="mt-5 space-y-8 border-b lg:mt-0 border-gray-900/10 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:pb-0">
            <form wire:submit.prevent="submit" enctype="multipart/form-data">
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
        wire:model.live="no_hp" placeholder="081234567890" pattern="[0-9]*" inputmode="numeric" />

    @error('no_hp')
    <p class="text-red-500 text-sm mt-1">
        {{ $message }}
    </p>
    @enderror
</div>


                <div class="py-3 sm:py-6">
                    <livewire:components.text-input colorText="text-grey" label="Email" name="email"
                        placeholder="pstbps@gmail.com" type="email" wire:model="email" />
                </div>

                

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
                    'perpustakaan' => 'Perpustakaan',
                    'konsultasi_statistik' => 'Konsultasi Statistik',
                    'rekomendasi_statistik' => 'Rekomendasi Statistik',
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
                            placeholder="Sebutkan tujuan lainnya. ex : Permohonan pengusulan magang di Kantor BPS Kota Bukittinggi" />
                    </div>
                </div>


                <!-- Deskripsi Tambahan -->
                 <div class="py-3 sm:py-6">
    <livewire:components.text-input 
        colorText="text-grey" 
        type="textarea" 
        rows="4" 
        name="deskripsi"
        label="Deskripsi / Keterangan Tambahan"
        placeholder="Contoh: Permintaan data Tingkat Pengangguran Kota Bukittinggi Tahun 2025
"
        wire:model="deskripsi"
        :optional="true" />
</div>


                <!-- Upload KTP - Bagian yang diperbaiki -->
                <div class="py-3 sm:py-6" wire:key="ktp-upload-section">
    <div class="grid grid-cols-1 gap-y-2 sm:grid-cols-3 sm:gap-x-4 sm:items-start">

        <!-- LABEL (KIRI) -->
        <label class="block text-lg font-bold text-grey sm:pt-2">
            Upload KTP
        </label>

        <!-- INPUT (KANAN) -->
        <div class="sm:col-span-2">
            <input
                type="file"
                wire:model.defer="ktp"
                accept=".jpg,.jpeg,.png,.pdf"
                class="block w-full text-sm text-gray-700
                       border border-gray-300 rounded-lg
                       bg-white cursor-pointer
                       focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400
                       file:mr-4 file:py-2 file:px-4
                       file:rounded-l-lg file:border-0
                       file:text-sm file:font-semibold
                       file:bg-yellow-400 file:text-gray-900
                       hover:file:bg-yellow-300"
            />

            <!-- Helper -->
            <p class="mt-1 text-xs text-white">
                JPG, PNG, PDF • Maks 2MB
            </p>

            <!-- Loading indicator untuk file upload -->
            <div wire:loading wire:target="ktp" class="mt-2">
                <div class="flex items-center text-sm text-yellow-400">
                    <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-yellow-400 mr-2"></div>
                    Mengunggah file...
                </div>
            </div>

            <!-- Error -->
            @error('ktp')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>
</div>

                <!-- Tombol Submit dengan perbaikan wire:target -->
                <div class="flex items-center justify-end mt-6 gap-x-6">
                    <button type="submit" 
                            wire:loading.attr="disabled"
                            wire:target="submit"
                            class="inline-flex items-center justify-center w-full px-4 py-3 text-sm font-bold text-white border border-transparent rounded-lg gap-x-2 sm:text-lg 
                            @if($this->isFromWhatsApp) bg-lightYellow hover:bg-lightYellow/80 focus:bg-lightYellow/80
                            @else bg-lightYellow hover:bg-lightYellow/80 focus:bg-lightYellow/80
                            @endif
                            disabled:opacity-50 disabled:pointer-events-none">
                        <span wire:loading.remove wire:target="submit">
                            Kirim
                        </span>
                        <span wire:loading wire:target="submit">
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
                    @if($this->isFromWhatsApp)
                        modal-wa
                    @else
                        modal-web
                    @endif">

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
                        <div class="queue-box 
                            @if($this->isFromWhatsApp)
                                border-green-500 text-green-500
                            @else
                                border-yellow-400 text-yellow-400
                            @endif">
                            {{ $nomorAntrian ? sprintf('%03d', $nomorAntrian) : '000' }}
                        </div>
                        <!-- Tambahan info bahwa antrian terpisah -->
                        <div class="mt-2 text-xs opacity-75">
                            @if ($this->isFromWhatsApp)
                            <i class="fa-solid fa-circle-info"></i>
                            Antrian WhatsApp terpisah dari antrian Web
                            @else
                            <i class="fa-solid fa-circle-info"></i>
                            Antrian Web terpisah dari antrian WhatsApp
                            @endif
                        </div>
                    </div>

                    <!-- Waktu -->
                    <p class="modal-time">
                        <i class="fa-regular fa-clock"></i>
                        {{ now()->format('H:i') }} • {{ now()->format('d/m/Y') }}
                    </p>

                    <!-- Info -->
                    <div class="modal-info 
                        @if($this->isFromWhatsApp)
                            border-green-500
                        @else
                            border-yellow-400
                        @endif">
                        <b>Pendaftaran berhasil!</b><br>
                        Silakan menunggu panggilan petugas
                    </div>

                <!-- ================= FOOTER ================= -->
                <div class="modal-footer">
                    <!-- TOMBOL DOWNLOAD PDF -->
                    <button 
    wire:click="downloadPdf"
    wire:target="downloadPdf"
    wire:loading.attr="disabled"
    type="button" 
    class="btn btn-outline print-hidden flex items-center justify-center gap-2
        text-white border-white hover:bg-white hover:text-gray-900">
    <i class="fa-solid fa-file-pdf"></i>
    <span wire:loading.remove wire:target="downloadPdf">
        Unduh Bukti Pendaftaran (PDF)
    </span>
    <span wire:loading wire:target="downloadPdf">
        <i class="fa-solid fa-spinner fa-spin"></i> Membuat PDF...
    </span>
</button>

                    <!-- TOMBOL PRINT DIHAPUS DARI SINI -->

                    <button onclick="window.location.href='/'" type="button" 
                        class="btn btn-primary print-hidden
                            @if($this->isFromWhatsApp)
                                bg-green-600 hover:bg-green-700
                            @else
                                bg-yellow-600 hover:bg-yellow-700
                            @endif
                            text-white">
                        Kembali ke Halaman Utama
                    </button>

                    <p class="modal-footer-text">
                        Sistem Buku Tamu Digital • BPS
                    </p>
                </div>
            </div>
        </div>
    </div>
    
    
    
    @endif
</div>