<div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 ">
    <label for="{{ $name }}" class="block sm:text-lg text-sm font-bold leading-6 {{ $colorText }}">
        {{ $label }}
    </label>
    <div class="mt-2 sm:col-span-2 sm:mt-0">
        @if($type === 'number')
            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-lightYellow max-w-1">
                <input

                    id="{{ $name }}"
                    type="number" 
                    wire:model='value' 
                    placeholder="{{ $placeholder }}" 
                    min="{{ $min }}" 
                    max="{{ $max }}" 
                    class=" @if(isset($errorsBag[$name])) ring-red-500 ring-2 @endif block rounded-l-md flex-1 border-0 bg-white py-1.5 pl-3 text-black placeholder:text-gray-400 focus:ring-0  sm:text-lg text-sm sm:leading-6"
                />
                @if($span)
                    <span class="flex select-none rounded-r-md items-center pl-3 pr-3 text-black bg-white sm:text-lg text-sm">{{ $span }}</span>
                @endif
            </div>
        @elseif ($type === 'textarea')
            <textarea 
                id="{{ $name }}" 
                placeholder="{{ $placeholder }}"
                wire:model='value' 
                rows="{{ $rows }}" 
                class=" @if(isset($errorsBag[$name])) ring-red-500 ring-2 @endif block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-lightYellow sm:text-lg text-sm  sm:leading-6  ">
            </textarea>
        @else
            <input 
                id="{{ $name }}"
                type="{{ $type }}" 
                wire:model='value' 
                placeholder="{{ $placeholder }}"
                @if ($type === 'tel')
                    inputmode="{{ $inputmode }}"
                    pattern="{{ $pattern }}"
                @endif
                class="@if ($type === 'tel')
                    max-w-44
                @endif @if(isset($errorsBag[$name])) ring-red-500 ring-2 @endif block w-full rounded-md border-0 py-1.5 text-black shadow-sm ring-1 ring-inset ring-gray-300+ placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-lightYellow sm:text-lg text-sm sm:leading-6 "
            />
        @endif

        {{-- Menampilkan Error yang Diterima --}}
        @if(isset($errorsBag[$name]))
            <span class="text-red-500 text-sm">{{ $errorsBag[$name] }}</span>
        @endif
    </div>
</div>


@script
<script>
    $(document).ready(function() {
        $('#{{ $name }}').on('change', function(event){
            $wire.$set('value', event.target.value);
        })
    });
</script>
@endscript