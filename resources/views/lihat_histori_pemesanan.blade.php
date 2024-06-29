@extends('layouts.app')
@section('title', 'Histori Pemesanan - Gor Griya Srimahi Indah')
@php
  use Carbon\Carbon;    
@endphp
@section('content')
@if(isset($transfer) and $transfer->metode_pembayaran == 'transfer')
<div id="bukti-pembayaran-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
	<div class="relative p-4 w-full max-w-screen-sm max-h-full">
			<!-- Modal content -->
			<div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
					<!-- Modal header -->
					<div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
							<h3 class="text-xl font-semibold text-gray-900 dark:text-white">
									Bukti Pembayaran
							</h3>
							<button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="bukti-pembayaran-modal">
									<svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
											<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
									</svg>
									<span class="sr-only">Close modal</span>
							</button>
					</div>
					<!-- Modal body -->
					<div class="p-4 md:p-5 space-y-4">
							<img src="{{ asset($transfer->bukti_pembayaran) }}" alt="" srcset="">
					</div>
			</div>
	</div>
</div>
@endif
<div id="tambah_modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
	<div class="relative p-4 w-full max-w-md max-h-full">
		<div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
			<!-- Modal header -->
			<div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
				<h3 class="w-full text-xl text-center font-semibold text-gray-900 dark:text-white">
					Review
				</h3>
				<button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="tambah_modal">
					<svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
						<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
					</svg>
					<span class="sr-only">Close modal</span>
				</button>
			</div>
			<!-- Modal body -->
			<form method="POST" action="{{route('review.store')}}" class="p-4 md:p-5 flex flex-col gap-4">
				@csrf
				<input type="hidden" name="pemesanan_id" value="{{$purchaseHistory->id}}">
				<div>
					<label for="tanggal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Komentar dan kritik</label>
					<textarea rows="5" name="komentar" placeholder="Masukkan komentar atau kritik" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required></textarea>
					<span class="text-xs text-red-600">{{ $errors->review->first('komentar') }}</span>
				</div>
				<button type="submit" class="text-nowrap w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
					Review
				</button>
			</form>
			</div>
		</div>
	</div>
</div>

<div class="w-full min-h-[100dvh]">
	@include('components.navbar')
	<section class="min-h-[100dvh] bg-center bg-cover bg-no-repeat bg-[url('https://plus.unsplash.com/premium_photo-1663039984787-b11d7240f592?q=80&w=3270&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')] bg-gray-700 bg-blend-multiply">
		<div class="mx-auto max-w-screen-xl h-full flex flex-col items-center justify-center">
			<div class="w-full max-w-screen-md mt-32 p-4 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
				<div class="flex flex-col gap-2.5 w-full border p-2.5 rounded-lg">
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
				@if(isset($transfer))
					<div class="flex justify-between gap-1.5 w-full border p-2.5 rounded-lg mt-4">
						<div class="flex font-medium">
							Metode Pembayaran
						</div>
						<div class="flex">
							{{$transfer->metode_pembayaran}}
						</div>
					</div>
				@endif
				<div class="flex justify-between gap-1.5 w-full border p-2.5 rounded-lg mt-4">
					<div class="flex font-medium">
						Total
					</div>
					<div class="flex">
						Rp{{number_format($purchaseHistory->total_harga,0,'','.')}}
					</div>
				</div>
				@if(isset($review->komentar))
				<div class="flex flex-col gap-1.5 w-full border p-2.5 rounded-lg mt-4">
					<div class="flex justify-between text-xs font-medium">
						Kritik atau Komentar
					</div>
					<div class="flex justify-between">
						{{$review->komentar}}
					</div>
				</div>
				@endif
				<div class="flex items-center justify-end gap-2.5 mt-4">
					@if($purchaseHistory->status == 'belum dibayar')
						<div class="flex justify-end">
							<a href="{{route('pembayaran.view', ['kode_pemesanan' => $purchaseHistory->kode_pemesanan])}}" class="px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Bayar</a>
						</div>
						<form method="POST" action="{{route('booking.update', $purchaseHistory->id)}}" class="flex">
							@csrf @method('put')
							<input type="hidden" name="status" value="dibatalkan">
							<button type="submit" class="rounded-lg focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium text-xs px-3 py-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
								Batalkan
							</button>
						</form>
					@endif
					@if(($purchaseHistory->status == 'dibayar' or $purchaseHistory->status == 'menunggu konfirmasi') and $transfer->metode_pembayaran == 'transfer')
					<div class="flex justify-end">
						<button data-modal-target="bukti-pembayaran-modal" data-modal-toggle="bukti-pembayaran-modal" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 rounded-lg px-3 py-2 text-xs font-medium dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
							Lihat bukti pembayaran
						</button>
					</div>
					@endif
					@if($purchaseHistory->status == 'dibayar' and !isset($review->komentar))
					<div class="flex justify-end">
						<button type="button" data-modal-target="tambah_modal" data-modal-toggle="tambah_modal" class="px-3 py-2 text-xs font-medium text-center text-white bg-gray-700 rounded-lg hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
							Review
						</button>
					</div>
					@endif
				</div>
			</div>
		</div>
	</section>
</div>
@endsection