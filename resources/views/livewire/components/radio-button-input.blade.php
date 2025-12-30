<fieldset>
    <legend class="sr-only">{{ $label }}</legend>
    <div class="sm:grid sm:grid-cols-3 sm:items-baseline sm:gap-4">
        <div class="sm:text-lg text-sm font-bold leading-6 {{ $colorText }}" aria-hidden="true">{{ $label }}</div>
        <div class="mt-1 sm:col-span-2 sm:mt-0">
            <div class="max-w-lg">
                <div class="sm:space-y-6 space-y-3" >

                    @foreach ($options as $key => $option)
                        <div class="flex items-center gap-x-3" >
                            <input id="{{ $key }}" name="{{ $name }}" type="radio" value="{{ $key }}"
                                   wire:model="input" 
                                   @change="$dispatch('{{ $name }}-changed', '{{ $key }}')"
                                   class="w-4 h-4 text-lightYellow border-gray-300 focus:ring-lightYellow @if(isset($errorsBag[$name])) ring-red-500 ring-2 @endif">
                            <label for="{{ $key }}" class="block sm:text-lg text-sm leading-6 {{ $colorText }}">
                                {{ $option }}
                            </label>
                        </div>
                    @endforeach

                </div>
            </div>
            @if (isset($errorsBag[$name]))
                <span class="text-red-500 text-sm">{{ $errorsBag[$name] }}</span>
            @endif
        </div>
    </div>
</fieldset>
