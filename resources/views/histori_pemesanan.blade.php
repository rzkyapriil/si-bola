@extends('layouts.app')
@section('title', 'Histori Pemesanan - Gor Griya Srimahi Indah')
@php
  use Carbon\Carbon;    
@endphp
@section('content')
<div class="w-full min-h-[100dvh]">
	@include('components.navbar')

	<section class="min-h-[100dvh] bg-center bg-cover bg-no-repeat bg-[url('https://plus.unsplash.com/premium_photo-1663039984787-b11d7240f592?q=80&w=3270&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')] bg-gray-700 bg-blend-multiply">
		<div class="mx-auto max-w-screen-xl h-full flex flex-col items-center justify-center">
			<div class="w-full max-w-screen-lg mt-32 mb-20 p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
				<div class="flex flex-col gap-4">
					<div class="flex">
						<form method="GET" action="{{route('histori-pemesanan.index')}}" class="w-full mx-auto">
							<div class="flex">
									<div class="relative w-full">
											<input type="search" name="cari" value="{{$cari}}" class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-s-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500" placeholder="Cari kode pemesanan" />
											<button type="submit" class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-blue-700 rounded-e-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
													<svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
															<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
													</svg>
													<span class="sr-only">Search</span>
											</button>
									</div>
							</div>
						</form>
					</div>
				@foreach($purchaseHistories as $purchaseHistory)
				<div class="flex w-full border rounded-lg">
					<div class="flex flex-col gap-2.5 w-full p-2.5">
						<div class="text-xs flex justify-between items-center">
							<div class="flex items-center gap-2.5">
								<div>{{$purchaseHistory->kode_pemesanan}}</div>
								<div class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{$purchaseHistory->status}}</div>
							</div>
							<div class="flex items-center gap-1.5">
								<div class="uppercase">{{Carbon::parse($purchaseHistory->tanggal)->translatedFormat('d F Y')}} |</div>
								<div>{{Carbon::parse($purchaseHistory->waktu_mulai)->translatedFormat('H:s')}}</div>
								<div>-></div>
								<div>{{Carbon::parse($purchaseHistory->waktu_selesai)->translatedFormat('H:s')}}</div>
							</div>
						</div>
						<div class="flex justify-between font-medium">
							<div>{{$purchaseHistory->nama}}</div>
							<div>{{$purchaseHistory->lapangan}}</div>
						</div>
					</div>
					<div class="ms-4 flex">
						@if($purchaseHistory->status == 'belum dibayar')
						<a href="{{route('pembayaran.view', ['kode_pemesanan' => $purchaseHistory->kode_pemesanan])}}" class="flex items-center px-3 py-2 text-xs font-medium text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
							Bayar
						</a>
						<form method="POST" action="{{route('histori-pemesanan.update', $purchaseHistory->id)}}" class="flex">
							@csrf @method('put')
							<input type="hidden" name="status" value="dibatalkan">
							<button type="submit" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium text-xs px-3 py-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
								Batalkan
							</button>
						</form>
						@endif
						<a href="{{route('histori-pemesanan.view', $purchaseHistory->id)}}" class="flex items-center px-3 py-2 text-xs font-medium text-white bg-gray-700 rounded-e-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
							Lihat
						</a>
					</div>
				</div>
				@endforeach
				<div class="flex flex-col items-center">
					<div class="inline-flex items-center justify-between gap-2.5 w-full">
						<!-- Buttons -->
						<a href="{{$purchaseHistories->previousPageUrl()}}" class="flex items-center justify-center px-3 h-8 text-sm font-medium text-white bg-gray-800 rounded hover:bg-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
								<svg class="w-3.5 h-3.5 me-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
									<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H1m0 0 4 4M1 5l4-4"/>
								</svg>
								Prev
						</a>
						<span class="text-sm text-gray-700 dark:text-gray-400">
							Showing 
							<span class="font-semibold text-gray-900 dark:text-white">
								{{$purchaseHistories->currentPage()}}
							</span> to
							<span class="font-semibold text-gray-900 dark:text-white">
								{{$purchaseHistories->lastPage()}}
							</span> of 
							<span class="font-semibold text-gray-900 dark:text-white">
								{{$purchaseHistories->total()}}
							</span> Entries
						</span>
						<a href="{{$purchaseHistories->nextPageUrl()}}" class="flex items-center justify-center px-3 h-8 text-sm font-medium text-white bg-gray-800 border-0 border-s border-gray-700 rounded hover:bg-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
								Next
								<svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
								<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
							</svg>
						</a>
					</div>
				</div>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection