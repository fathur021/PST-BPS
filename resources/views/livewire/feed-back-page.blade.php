<div class="relative isolate bg-white px-6 py-24 sm:py-32 lg:px-8">
	@livewire('partials.svg-background')

	<div class="mx-auto max-w-xl lg:max-w-4xl">
		<!-- Heading -->
		<div x-data="{ show: false }" x-init="setTimeout(() => show = true, 300)" 
		     x-show="show"
		     x-transition:enter="transition transform ease-out duration-500"
		     x-transition:enter-start="opacity-0 translate-x-[-20px]"
		     x-transition:enter-end="opacity-100 translate-x-0"
		     :class="{ 'invisible': !show, 'relative': show, 'absolute': !show }">
			<h2 class="text-4xl font-bold tracking-tight text-gray-900 text-center">Give Feedback</h2>
		</div>

		<!-- Subheading -->
		<div x-data="{ show: false }" x-init="setTimeout(() => show = true, 500)" 
		     x-show="show"
		     x-transition:enter="transition transform ease-out duration-500"
		     x-transition:enter-start="opacity-0 translate-x-[-20px]"
		     x-transition:enter-end="opacity-100 translate-x-0"
		     :class="{ 'invisible': !show, 'relative': show, 'absolute': !show }">
			<p class="mt-2 text-lg leading-8 text-gray-600 text-center">👋 Help Us Improve</p>
		</div>

		<!-- Form -->
		<div x-data="{ show: false }" x-init="setTimeout(() => show = true, 700)" 
		     x-show="show"
		     x-transition:enter="transition transform ease-out duration-500"
		     x-transition:enter-start="opacity-0 translate-x-[-20px]"
		     x-transition:enter-end="opacity-100 translate-x-0"
		     :class="{ 'invisible': !show, 'relative': show, 'absolute': !show }"
		     class="mt-10 flex flex-col gap-16 sm:gap-y-20 lg:flex-row">
			@livewire('feedback.feedback-form')
		</div>
	</div>
</div>
