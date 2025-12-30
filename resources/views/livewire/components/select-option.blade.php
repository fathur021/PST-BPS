<div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4">
 <label for="provinsi"
  class="block sm:text-lg text-sm  font-bold leading-6 {{ $colorText }} sm:pt-1.5">{{ $label }}</label>
 <div class="mt-2 sm:col-span-2 sm:mt-0">
    <div class="@if(isset($errorsBag[$name])) border-2 border-red-500  @endif">
         <div wire:ignore>

        <select type="text" style="width: 100%; height: 100%" id="{{ $name }}" wire:model.live='value'
        placeholder="Sumatera Barat"
        class=" block w-full rounded-md border-0 py-1.5  shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-lightYellow sm:max-w-xs sm:text-sm sm:leading-6">
        <option value="">Pilih {{ $label }}</option>
        @foreach ($options as $option)
         <option value="{{ $option['id'] }}">{{ $option['name'] }}</option>
        @endforeach
       </select>
      </div>

    </div>
  @if (isset($errorsBag[$name]))
   <span class="text-red-500 text-sm">{{ $errorsBag[$name] }}</span>
  @endif
 </div>
</div>

@script
 <script>
  $(document).ready(function() {
   $('#{{ $name }}').select2();
   $('#{{ $name }}').on('change', function(event) {
    $wire.$set('value', event.target.value);
   })
  });
 </script>
@endscript
