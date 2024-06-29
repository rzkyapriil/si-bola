@extends('layouts.admin')
@section('title', 'Gor Griya Srimahi Indah')

@php
	use Carbon\Carbon;
@endphp

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
							<img src="{{ asset($booking->bukti_pembayaran) }}" alt="" srcset="">
					</div>
			</div>
	</div>
</div>

@section('admin-content')
	<div class="flex flex-col items-center mx-auto w-full max-w-screen-sm">
		<div class="flex items-center justify-between w-full mb-4">
			<div>
				<h1 class="text-2xl font-bold text-center">Booking</h1>
			</div>
			<div class="flex gap-2 items-center justify-end">
				@if($booking->status == 'menunggu konfirmasi')
					<button data-modal-target="bukti-pembayaran-modal" data-modal-toggle="bukti-pembayaran-modal" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 rounded-lg px-3 py-2 text-xs font-medium dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
						Lihat bukti pembayaran
					</button>
					<form method="POST" action="{{route('booking.update', $booking->id)}}" class="flex mb-0">
						@csrf @method('put')
						<input type="hidden" name="status" value="dibayar">
						<button type="submit" class="px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
							Konfirmasi
						</button>
					</form>

					{{-- Batalkan --}}
					<form method="POST" action="{{route('booking.update', $booking->id)}}" class="flex mb-0">
						@csrf @method('put')
						<input type="hidden" name="status" value="dibatalkan">
						<button type="submit" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
							Batalkan
						</button>
					</form>
				@endif
				{{-- Hapus --}}
				<form method="POST" action="{{route('booking.destroy', $booking->id)}}" class="flex mb-0">
					@csrf @method('delete')
					<button type="submit" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">
						Hapus
					</button>
				</form>
			</div>
		</div>
			<div class="flex flex-col w-full gap-2.5">
				<div class="flex flex-col gap-2.5 w-full border p-2.5 rounded-lg">
					<div class="text-xs flex justify-between items-center">
						<div class="flex items-center gap-2.5">
							<div>{{$booking->kode_pemesanan}}</div>
							<div class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{$booking->status}}</div>
						</div>
						<div class="flex items-center gap-2.5">
							<div class="uppercase">{{Carbon::parse($booking->tanggal)->translatedFormat("d F Y")}}</div>
							<div class="flex gap-1">
								<div>{{Carbon::parse($booking->waktu_mulai)->format("H:i")}}</div>
								<div>-></div>
								<div>{{Carbon::parse($booking->waktu_selesai)->format("H:i")}}</div>
							</div>
						</div>
					</div>
					<div class="flex justify-between font-medium">
						<div>{{$booking->nama}}</div>
						<div>{{$booking->lapangan}}</div>
					</div>
				</div>
				<div class="flex justify-between gap-1.5 w-full border p-2.5 rounded-lg">
					<div class="flexfont-bold">
						Total
					</div>
					<div class="flex">
						Rp{{number_format($booking->total_harga,0,'','.')}}
					</div>
				</div>
				@if(isset($review))
				<div class="flex flex-col gap-1.5 w-full border p-2.5 rounded-lg">
					<div class="flex justify-between text-sm font-medium">
						Kritik atau Komentar
					</div>
					<div class="flex justify-between text-xs">
						{{$review->komentar}}
					</div>
				</div>
				@endif
			</div>
	</div>
@endsection