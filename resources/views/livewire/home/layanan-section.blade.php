<section aria-labelledby="favorites-heading" x-data="{ show: true }">
    <div class="px-4 py-20 mx-auto max-w-7xl sm:px-6 sm:py-18 lg:px-8">
        <div class="sm:flex sm:items-baseline sm:justify-between">
            <h2 id="favorites-heading" class="text-4xl font-bold text-gray-900">Layanan Utama</h2>
        </div>
        <div class="grid h-auto w-auto grid-cols-2 mt-6 md:w-auto lg:grid-cols-4 gap-y-10 gap-x-6 sm:gap-y-10 lg:gap-x-8">
            <template x-for="(item, i) in [0, 1, 2, 3]" :key="i">
                <div 
                    x-show="show"
                    class="relative flex flex-col group">
                    <div class="flex flex-col flex-grow w-full overflow-hidden border-4 rounded-lg bg-grey sm:aspect-h-3 sm:aspect-w-2 group-hover:opacity-75 sm:h-auto border-lightBlue">
                        <div class="bg-lightBlue">
                            <div class="m-10 rounded-full md:m-5 bg-grey">
                                <img class="p-6 md:p-10" :src="getImage(i)" :alt="getAlt(i)">
                            </div>
                        </div>
                        <div>
                            <div class="p-4">
                                <p class="text-xl md:text-2xl font-bold text-darkBlue" x-text="getTitle(i)"></p>
                                <p class="text-lightYellow">Layanan Umum </p>
                                <p x-text="getDescription(i)"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</section>

<script>
function getImage(index) {
    const images = [
        '{{ asset('img/perpustakaan-logo.svg') }}',
        '{{ asset('img/penjualan-logo.svg') }}',
        '{{ asset('img/konsultasi-logo.svg') }}',
        '{{ asset('img/rekomendasi-logo.svg') }}'
    ];
    return images[index];
}

function getAlt(index) {
    const alts = ['Logo Perpustakaan', 'Logo Penjualan', 'Logo Konsultasi', 'Logo Rekomendasi'];
    return alts[index];
}

function getTitle(index) {
    const titles = ['Perpustakaan', 'Penjualan', 'Konsultasi', 'Rekomendasi'];
    return titles[index];
}

function getDescription(index) {
    const descriptions = [
        'Publikasi statistik terbitan BPS dari berbagai kategori: kependudukan, sosial, sosial ekonomi, pertanian, dan lain lain.',
        'Layanan penjualan data mikro, publikasi elektronik, dan peta digital wilkerstat.',
        'Konsultasi terkait data, metadata, klasifikasi, dan produk statistik BPS lainnya.',
        'Layanan bagi instansi pemerintah yang akan melakukan survei dan mengajukan rekomendasi kegiatan statistik.'
    ];
    return descriptions[index];
}
</script>
