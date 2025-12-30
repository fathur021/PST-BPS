<div x-data="{ showHero: false, showLayanan: false, showAlur: false, showCta: false }">
    <div 
        x-intersect:enter="setTimeout(() => showHero = true, 200)" 
        x-intersect:leave="showHero = false" 
        x-bind:class="{ 'opacity-100': showHero, 'opacity-0': !showHero }" 
        class="transition-all duration-500 ease-out pt-16">
        @livewire('home.hero-section')
    </div>

    <div 
        x-intersect:enter="setTimeout(() => showLayanan = true, 200)" 
        x-intersect:leave="showLayanan = false" 
        x-bind:class="{ 'opacity-100 translate-y-0': showLayanan, 'opacity-0 translate-y-10': !showLayanan }" 
        class="transition-all duration-500 ease-out bg-grey">
        @livewire('home.layanan-section')
    </div>

    {{-- <div 
        x-intersect:enter="setTimeout(() => showAlur = true, 200)" 
        x-intersect:leave="showAlur = false" 
        x-bind:class="{ 'opacity-100 translate-y-0': showAlur, 'opacity-0 translate-y-10': !showAlur }" 
        class="transition-all duration-500 ease-out">
        @livewire('home.alur-layanan-section')
    </div> --}}

    <div 
        x-intersect:enter="setTimeout(() => showCta = true, 200)" 
        x-intersect:leave="showCta = false" 
        x-bind:class="{ 'opacity-100 translate-y-0': showCta, 'opacity-0 translate-y-10': !showCta }" 
        class="transition-all duration-500 ease-out">
        @livewire('home.cta-section')
    </div>
</div>
