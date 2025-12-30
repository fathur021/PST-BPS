<fieldset>
 <legend class="sr-only">{{ $label }}</legend>
 <div class="sm:grid sm:grid-cols-3 sm:gap-4">
  <div class="sm:text-lg text-sm font-bold leading-6 {{ $colorText }}" aria-hidden="true">{{ $label }}</div>
  <div class="mt-4 sm:col-span-2 sm:mt-0">
   <div class="max-w-lg sm:space-y-6 space-y-3">
    @foreach ($options as $value => $label)
     <div class="relative flex gap-x-3">
      <div class="flex items-center h-6">
       <input type="checkbox" id="{{ $name . '-' . $value }}" value="{{ $value }}" wire:model="input"
        class="@if(isset($errorsBag[$name])) ring-red-500 ring-2 @endif h-4 w-4 text-lightYellow border-gray-300 roundedfocus:ring-lightYellow" {{ in_array($value, $input) ? 'checked' : '' }} >
      </div>
      <div class="sm:text-lg text-sm leading-6">
       <label for="{{ $value }}" class="{{ $colorText }}">{{ $label }}</label>
      </div>
     </div>
    @endforeach
   </div>
   @if (isset($errorsBag[$name]))
    <span class="text-red-500 text-sm">{{ $errorsBag[$name] }}</span>
   @endif
  </div>
 </div>
</fieldset>

@script
 <script>
  $(document).ready(function() {
   function logSelectedCheckboxes() {
    var selectedValues = [];
    $('input[type="checkbox"]:checked').each(function() {
     selectedValues.push($(this).val());
    });
    Livewire.dispatch('{{ $name }}-changed', selectedValues);
   }

   $('input[type="checkbox"]').on('change', function() {
    logSelectedCheckboxes();
   });

   // Initial log on page load
   logSelectedCheckboxes();
  });
 </script>
@endscript
