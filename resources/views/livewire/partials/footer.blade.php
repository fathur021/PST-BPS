<footer aria-labelledby="footer-heading" class="bg-darkBlue">
	<h2 id="footer-heading" class="sr-only">Footer</h2>
	<div class="px-4 mx-auto text-white max-w-7xl sm:px-6 lg:px-8">
		<div class="pt-10 pb-10 xl:grid xl:grid-cols-3 xl:gap-8">
			<div class="gap-8 xl:col-span-2">
				<div>
					<div class="flex items-center w-auto gap-5 pb-4">
						<img class="h-14" src='{{ asset('img/logo-bps.webp') }}' alt="logo-BPS" />
						<div class="italic">
							<p class="-my-2 font-bold lg:text-xl">BADAN PUSAT STATISTIK</p>
							<p class="-my-2 font-bold lg:text-xl">KOTA BUKITTINGGI</p>
						</div>
					</div>
					<ul role="list" class="mt-6 space-y-4">
						<li class="text-sm">
							<a href="#" class=" hover:text-gray-600">BPS Kota Bukittinggi (Statistics of Bukittinggi Municipality)</a>
						</li>
						<li class="text-sm">
							<a href="#" class=" hover:text-gray-600">Jl. Perwira No. 50, Belakang Balok, Bukittinggi</a>
						</li>
						<li class="text-sm">
							<a href="#" class=" hover:text-gray-600">Telp (62-752) 21521</a>
						</li>
						<li class="text-sm">
							<a href="#" class=" hover:text-gray-600">Faks (62-752) 624629</a>
						</li>
						<li class="text-sm">
							<a href="#" class=" hover:text-gray-600">Mailbox : bps1375@bps.go.id</a>
						</li>
					</ul>
				</div>

			</div>
			{{-- <div class="mt-16 md:mt-16 xl:mt-0">
				<h3 class="text-sm font-medium text-gray-900">Sign up for our newsletter</h3>
				<p class="mt-6 text-sm text-gray-500">The latest deals and savings, sent to your inbox weekly.</p>
				<form class="flex mt-2 sm:max-w-md">
					<label for="email-address" class="sr-only">Email address</label>
					<input id="email-address" type="text" autocomplete="email" required
						class="w-full min-w-0 px-4 py-2 text-indigo-500 placeholder-gray-500 bg-white border border-gray-300 rounded-md shadow-sm appearance-none focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
					<div class="flex-shrink-0 ml-4">
						<button type="submit"
							class="flex items-center justify-center w-full px-4 py-2 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Sign
							up</button>
					</div>
				</form>
			</div> --}}
		</div>
		<div class="py-10 border-t border-gray-200">
			<p class="text-sm text-gray-500">Hak Cipta © {{ date('Y') }} BPS Kota Bukittinggi</p>
		</div>
	</div>
</footer>
