@extends('layouts.admin')
@section('title', 'Gor Griya Srimahi Indah')

@section('admin-content')
  <div class="mb-6">
		<h1 class="text-2xl font-bold">Booking</h1>
	</div>

	<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
		<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
				<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
						<tr>
								<th scope="col" class="px-6 py-3">
										No
								</th>
								<th scope="col" class="px-6 py-3">
										Status
								</th>
								<th scope="col" class="px-6 py-3">
										Kode
								</th>
								<th scope="col" class="px-6 py-3">
										Tanggal
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
								<span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{$booking->status}}</span>
							</td>
							<td class="px-6 py-4">
								{{$booking->kode_pemesanan}}
							</td>
							<td class="px-6 py-4">
								{{$booking->tanggal}}
							</td>
							<td class="px-6 py-4">
								{{$booking->waktu_mulai}} -> {{$booking->waktu_selesai}}
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