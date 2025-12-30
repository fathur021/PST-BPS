<form wire:submit.prevent="submit" class="lg:flex-auto">
	<div class="grid grid-cols-1 gap-x-8 gap-y-4 sm:grid-cols-2">
		<div class="sm:col-span-2">
			<label for="nama_lengkap" class="block text-lg font-semibold leading-6 text-gray-900">Nama Lengkap <span class="text-red-500">*</span></label>
			<div class="mt-3">
				<input id="nama_lengkap" name="nama_lengkap" rows="4" wire:model="nama_lengkap" type='text'
				 class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-lg sm:leading-6"></input>
			</div>
            @error('nama_lengkap')
				<span class="text-red-500">{{ $message }}</span>
            @enderror
		</div>
		<!-- Petugas PST Section -->
		<div>
			<label for="petugas-pst" class="block text-lg font-medium leading-6 text-gray-900">Petugas Informasi Publik <span class="text-red-500">*</span></label>
			<div class="relative mt-3">
                <div class="bg-white rounded-2xl">
                    @if (!is_null($petugasPstPhotoUrl))
                    <img class="w-48 h-48 mx-auto rounded-lg md:h-56 md:w-56" src="{{ asset('storage/'.$petugasPstPhotoUrl) }}" alt="">
                    @endif
                    <div wire:ignore class="mt-6 text-base font-semibold leading-7 tracking-tight text-white">
                        <select wire:model="petugas_pst" id="petugas-pst" style="width: 100%; height: 100%"
                            class="select-2 w-full rounded-md border-0 bg-white py-1.5 pl-3 pr-12 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-lg sm:leading-6">
                            <option value="">Pilih Petugas Informasi Publik</option>
                            @foreach ($this->listPetugasPst as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        </div>
                  </div>
				
                @error('petugas_pst')
					<span class="text-red-500">{{ $message }}</span>
                @enderror
			</div>
		</div>

		<!-- Petugas PST Rating Section -->
        <div x-data="{
            rating: @entangle('kepuasan_petugas_pst'),
            hoverRating: 0,
            ratings: [{'amount': 1, 'label':'Terrible'}, {'amount': 2, 'label':'Bad'}, {'amount': 3, 'label':'Okay'}, {'amount': 4, 'label':'Good'}, {'amount': 5, 'label':'Great'}],
            rate(amount) {
                if (this.rating == amount) {
                    this.rating = 0;
                } else {
                    this.rating = amount;
                }
            },
            currentLabel() {
                let r = this.rating;
                if (this.hoverRating != this.rating) r = this.hoverRating;
                let i = this.ratings.findIndex(e => e.amount == r);
                if (i >= 0) {
                    return this.ratings[i].label;
                } else {
                    return '';
                }
            }
        }" class="flex flex-col items-center">
            <label class="block text-lg font-semibold leading-6 text-gray-900">Bagaimana Anda menilai pelayanan keseluruhan dari petugas Informasi Publik? <span class="text-red-500">*</span></label>
            <div class="relative mt-2">
                <div class="flex items-center justify-center space-x-0">
                    <template x-for="(star, index) in ratings" :key="index">
                        <button type="button" @click="rate(star.amount)" @mouseover="hoverRating = star.amount" @mouseleave="hoverRating = rating" aria-hidden="true" :title="star.label" class="w-12 p-1 m-0 text-gray-400 rounded-sm cursor-pointer fill-current focus:outline-none focus:shadow-outline" :class="{'text-gray-600': hoverRating >= star.amount, 'text-yellow-400': rating >= star.amount && hoverRating >= star.amount}">
                            <svg class="transition duration-150 w-15" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </button>
                    </template>
                </div>
                <div class="flex items-center justify-center p-2 text-lightYellow">
                    <template x-if="rating || hoverRating">
                        <p x-text="currentLabel()"></p>
                    </template>
                    <template x-if="!rating && !hoverRating">
                        <p>Berikan Rating!</p>
                    </template>
                </div>
                @error('kepuasan_petugas_pst')
					<span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
        </div>

		<!-- Front Office Section -->
		<div>
			<label for="front-office" class="block text-lg font-medium leading-6 text-gray-900">Front Office <span class="text-red-500">*</span></label>
			<div class="relative mt-2">
                <div class="bg-white rounded-2xl">
                    @if (!is_null($frontOfficePhotoUrl))
                    <img class="w-48 h-48 mx-auto rounded-lg md:h-56 md:w-56" src="{{ asset('storage/'.$frontOfficePhotoUrl) }}" alt="">
                    @endif
                    <div wire:ignore class="mt-6 text-base font-semibold leading-7 tracking-tight text-white">
                        <select  wire:model="front_office" id="front-office" style="width: 100%; height: 100%"
                            class="select-2 w-full rounded-md border-0 bg-white py-1.5 pl-3 pr-12 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-lg sm:leading-6">
                            <option value="">Pilih Front Office</option>
                            @foreach ($this->listFrontOffice as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                  </div>
                @error('front_office')
					<span class="text-red-500">{{ $message }}</span>
                @enderror
			</div>
		</div>
		
		<!-- Front Office Rating Section -->
		<div x-data="{
            rating: @entangle('kepuasan_petugas_front_office'),
            hoverRating: 0,
            ratings: [{'amount': 1, 'label':'Terrible'}, {'amount': 2, 'label':'Bad'}, {'amount': 3, 'label':'Okay'}, {'amount': 4, 'label':'Good'}, {'amount': 5, 'label':'Great'}],
            rate(amount) {
				console.log('Rating amount:', amount);
                if (this.rating == amount) {
                    this.rating = 0;
                } else {
                    this.rating = amount;
                }
            },
            currentLabel() {
                let r = this.rating;
                if (this.hoverRating != this.rating) r = this.hoverRating;
                let i = this.ratings.findIndex(e => e.amount == r);
                if (i >= 0) {
                    return this.ratings[i].label;
                } else {
                    return '';
                }
            }
        }" class="flex flex-col items-center">
            <label class="block text-lg font-semibold leading-6 text-gray-900">Bagaimana Anda menilai pelayanan keseluruhan dari Front Office? <span class="text-red-500">*</span></label>
            <div class="relative mt-2">
                <div class="flex items-center justify-center space-x-0">
                    <template x-for="(star, index) in ratings" :key="index">
                        <button type="button" @click="rate(star.amount)" @mouseover="hoverRating = star.amount" @mouseleave="hoverRating = rating" aria-hidden="true" :title="star.label" class="w-12 p-1 m-0 text-gray-400 rounded-sm cursor-pointer fill-current focus:outline-none focus:shadow-outline" :class="{'text-gray-600': hoverRating >= star.amount, 'text-yellow-400': rating >= star.amount && hoverRating >= star.amount}">
                            <svg class="transition duration-150 w-15" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </button>
                    </template>
                </div>
                <div class="flex items-center justify-center p-2 text-lightYellow">
                    <template x-if="rating || hoverRating">
                        <p x-text="currentLabel()"></p>
                    </template>
                    <template x-if="!rating && !hoverRating">
                        <p>Berikan Rating!</p>
                    </template>
                </div>
                @error('kepuasan_petugas_front_office')
					<span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
        </div>

		<!-- Sarana dan Prasarana Section -->
		<div x-data="{
            rating: @entangle('kepuasan_sarana_prasarana'),
            hoverRating: 0,
            ratings: [{'amount': 1, 'label':'Terrible'}, {'amount': 2, 'label':'Bad'}, {'amount': 3, 'label':'Okay'}, {'amount': 4, 'label':'Good'}, {'amount': 5, 'label':'Great'}],
            rate(amount) {
				console.log('Rating amount:', amount);
                if (this.rating == amount) {
                    this.rating = 0;
                } else {
                    this.rating = amount;
                }
            },
            currentLabel() {
                let r = this.rating;
                if (this.hoverRating != this.rating) r = this.hoverRating;
                let i = this.ratings.findIndex(e => e.amount == r);
                if (i >= 0) {
                    return this.ratings[i].label;
                } else {
                    return '';
                }
            }
        }" class="flex flex-col items-center sm:col-span-2">
            <label class="block text-lg font-semibold leading-6 text-gray-900">Bagaimana Anda menilai pelayanan keseluruhan dari Sarana Prasarana?</label>
            <div class="relative mt-2">
                <div class="flex items-center justify-center space-x-0 ">
                    <template x-for="(star, index) in ratings" :key="index">
                        <button type="button" @click="rate(star.amount)" @mouseover="hoverRating = star.amount" @mouseleave="hoverRating = rating" aria-hidden="true" :title="star.label" class="w-12 p-1 m-0 text-gray-400 rounded-sm cursor-pointer fill-current focus:outline-none focus:shadow-outline" :class="{'text-gray-600': hoverRating >= star.amount, 'text-yellow-400': rating >= star.amount && hoverRating >= star.amount}">
                            <svg class="transition duration-150 w-15" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </button>
                    </template>
                </div>
                <div class="flex items-center justify-center p-2" class="text-lightYellow">
                    <template x-if="rating || hoverRating" >
                        <p x-text="currentLabel()" class="text-lightYellow"></p>
                    </template>
                    <template x-if="!rating && !hoverRating" >
                        <p class="text-lightYellow">Berikan Rating!</p>
                    </template>
                </div>
                @error('kepuasan_sarana_prasarana')
					<span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
        </div>

		<div class="sm:col-span-2">
			<label for="message" class="block text-lg font-semibold leading-6 text-gray-900 sm:text-center">Kritik dan Saran</label>
			<div class="mt-3">
				<textarea id="message" name="message" rows="4" wire:model="kritik_saran" type='text'
				 class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-lg sm:leading-6"></textarea>
			</div>
            @error('kritik_saran')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
		</div>

	</div>

	<div class="mt-10">
        <button type="submit" wire:loading.attr="disabled"
        class="inline-flex items-center justify-center w-full px-4 py-3 text-sm font-bold text-white border border-transparent rounded-lg gap-x-2 sm:text-lg bg-lightYellow hover:bg-lightYellow/80 focus:outline-none focus:bg-lightYellow/80 disabled:opacity-50 disabled:pointer-events-none">
        <span wire:loading.remove>Kirim</span>
        <span wire:loading>
         <div role="status">
          <svg aria-hidden="true" class="inline w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-green-500"
           viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
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

	<div x-data='{show: false}' x-show= 'show' :class="{ 'hidden': !show }" x-on:open-modal.window = "show = true"
	x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 "
	x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
	x-transition:leave-start="opacity-100 " x-transition:leave-end="opacity-0 " class="hidden">
		@livewire('feedback.modal-success-send')
	</div>
</form>


@script
<script>
$(document).ready(function() {
    // Inisialisasi select2 untuk petugas PST
    $('#petugas-pst').select2().on('change', function(e) {
        var selectedValue = $(this).val();
        @this.set('petugas_pst', selectedValue);
    });

    // Inisialisasi select2 untuk front office
    $('#front-office').select2().on('change', function(e) {
        var selectedValue = $(this).val();
        @this.set('front_office', selectedValue);
    });
});
</script>
@endscript