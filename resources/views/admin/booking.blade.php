@extends('layouts.admin')
@section('title', 'Booking')
@php
		use Carbon\Carbon;
@endphp
@section('admin-content')
<div class="flex flex-col md:flex-row items-center justify-between gap-4 md:gap-0 mb-6">
	<h1 class="text-2xl font-bold w-fit md:w-full">Booking</h1>

	<div class="flex w-full">
		<form method="GET" action="{{route('booking.index')}}" class="flex w-full mx-auto">
			<input type="search" name="cari" value="{{$cari}}" class="flex p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-s-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-s-gray-700" placeholder="Cari kode pemesanan" />
			<button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-e-lg text-sm px-3 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
					<svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
							<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
					</svg>
					<span class="sr-only">Search</span>
			</button>
		</form>
	</div>
</div>

	<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
		<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
				<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
						<tr>
								<th scope="col" class="px-6 py-3">
									No
								</th>
								<th scope="col" class="px-6 py-3">
									Tanggal & Waktu
								</th>
								<th scope="col" class="px-6 py-3">
									Kode Booking
								</th>
								<th scope="col" class="px-6 py-3">
									Status
								</th>
								<th scope="col" class="px-6 py-3">
									Waktu
								</th>
								<th scope="col" class="px-6 py-3">
									Action
								</th>
						</tr>
				</thead>
				<tbody>
						@forelse($bookings as $no => $booking)
						<tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
							<th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
								{{$no+1}}
							</th>
							<td class="px-6 py-4">
								<div class="flex text-nowrap">{{Carbon::parse($booking->tanggal)->translatedFormat('d F Y')}}<span class="ms-1.5">({{Carbon::parse($booking->waktu_mulai)->format('H:s')}} -> {{Carbon::parse($booking->waktu_selesai)->format('H:s')}})</span></div>
							</td>
							<td class="px-6 py-4">
								{{$booking->kode_pemesanan}}
							</td>
							<td class="px-6 py-4">
								<span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 text-nowrap">{{$booking->status}}</span>
							</td>
							<td class="px-6 py-4">
								Rp{{number_format($booking->total_harga,0,'','.')}}
							</td>
							<td class="px-6 py-4 space-x-2">
								<a href="{{route('booking.view', $booking->id)}}" class="font-medium text-gray-600 dark:text-gray-500 hover:underline">View</a>
							</td>
						</tr>
						@empty
						<tr>
							<td colspan="6" class="px-6 py-4 text-center">
								Data Kosong
							</td>
						</tr>
						@endforelse
				</tbody>
		</table>
	</div>
	<div class="flex flex-col items-center my-4">
		<!-- Help text -->
		<span class="text-sm text-gray-700 dark:text-gray-400">
				Showing 
				<span class="font-semibold text-gray-900 dark:text-white">
					{{$bookings->currentPage()}}
				</span> to
				<span class="font-semibold text-gray-900 dark:text-white">
					{{$bookings->lastPage()}}
				</span> of 
				<span class="font-semibold text-gray-900 dark:text-white">
					{{$bookings->total()}}
				</span> Entries
		</span>
		<div class="inline-flex mt-2 xs:mt-0">
			<!-- Buttons -->
			<a href="{{$bookings->previousPageUrl()}}" class="flex items-center justify-center px-3 h-8 text-sm font-medium text-white bg-gray-800 rounded-s hover:bg-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
					<svg class="w-3.5 h-3.5 me-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
						<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H1m0 0 4 4M1 5l4-4"/>
					</svg>
					Prev
			</a>
			<a href="{{$bookings->nextPageUrl()}}" class="flex items-center justify-center px-3 h-8 text-sm font-medium text-white bg-gray-800 border-0 border-s border-gray-700 rounded-e hover:bg-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
					Next
					<svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
					<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
				</svg>
			</a>
		</div>
	</div>
@endsection