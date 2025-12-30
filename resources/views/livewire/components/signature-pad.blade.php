<div x-data="signaturePad(@entangle('value'))">
 <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4">
  <label for="tanda_tangan" class="block sm:text-lg text-sm   font-bold leading-6 text-black sm:pt-1.5">Tanda
   tangan</label>
  <div class="mt-2 sm:col-span-2 sm:mt-0">
   <canvas x-ref="signature_canvas"
    class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-lightYellow sm:max-w-lg sm:text-lg text-sm  sm:leading-6"></canvas>
   <div class="py-6">
    <button type="button" @click="clearSignature" class="text-white bg-gray-800 hover:bg-gray-900 px-4 py-2 rounded-lg">
     Clear
    </button>

    <button type="button" @click="saveSignature"
     class="text-white bg-green-600 hover:bg-green-700 px-4 py-2 rounded-lg ml-2">
     Save
    </button>
   </div>
  </div>


 </div>

 <!-- Script untuk Signature Pad -->
 <script>
  document.addEventListener('alpine:init', () => {
   Alpine.data('signaturePad', (value) => ({
    signaturePadInstance: null,
    value: value,
    init() {
     this.signaturePadInstance = new SignaturePad(this.$refs.signature_canvas);
    },
    saveSignature() {
     if (this.signaturePadInstance.isEmpty()) {
      alert("Please provide a signature first.");
     } else {
      this.value = this.signaturePadInstance.toDataURL('image/png');
      this.$wire.set('value', this.value); // Mengirim data ke Livewire
      alert("Signature saved!");
     }
    },
    clearSignature() {
     this.signaturePadInstance.clear(); // Menghapus tanda tangan
    }
   }))
  });
 </script>
