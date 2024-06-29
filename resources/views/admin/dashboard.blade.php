@extends('layouts.admin')
@section('title', 'Dashboard')

@php
		use Carbon\Carbon;
@endphp

@section('admin-content')
  <div class="flex items-center justify-between mb-6">
		<h1 class="text-2xl font-bold">Dashboard</h1>

		<form method="GET" action="{{route('dashboard.index')}}" class="flex gap-2.5">
			<input id="inputYear" type="number" placeholder="Masukkan tahun" name="tahun" value="{{$tahun}}" min="2000" class="block p-2.5 w-fit text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-e-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500" required/>
			<button type="submit" class="p-2.5 text-sm font-medium h-full text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
				<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 -960 960 960" fill="currentColor">
						<path d="M380-320q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l224 224q11 11 11 28t-11 28q-11 11-28 11t-28-11L532-372q-30 24-69 38t-83 14Zm0-80q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z" />
				</svg>
			</button>
		</form>
	</div>

  <div class="flex items-center justify-between border rounded-lg">
		<div class="flex w-full flex-col p-3 border-e gap-1">
			<div>Total Booking</div>
			<div class="text-3xl font-bold">{{$total_booking}}</div>
		</div>
		<div class="flex w-full flex-col p-3 border-e gap-1">
			<div>Total Booking Selesai</div>
			<div class="text-3xl font-bold">{{$total_booking_selesai}}</div>
		</div>
		<div class="flex w-full flex-col p-3 border-e gap-1">
			<div>Menunggu Konfirmasi</div>
			<div class="text-3xl font-bold">{{$menunggu_konfirmasi}}</div>
		</div>
	</div>

	<div class="flex items-center justify-between my-6">
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
									Tanggal & Waktu
								</th>
								<th scope="col" class="px-6 py-3">
									Kode Booking
								</th>
								<th scope="col" class="px-6 py-3">
									Status
								</th>
								<th scope="col" class="px-6 py-3">
									Total Harga
								</th>
								@if(Auth::user()->hasRole('pegawai'))
								<th scope="col" class="px-6 py-3">
									Action
								</th>
								@endif
						</tr>
				</thead>
				<tbody>
						@forelse($bookings as $no => $booking)
						<tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
							<th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
								{{$no+1}}
							</th>
							<td class="px-6 py-4">
								<div class="flex">{{Carbon::parse($booking->tanggal)->translatedFormat('d F Y')}}<span class="ms-1.5">({{Carbon::parse($booking->waktu_mulai)->format('H:s')}} -> {{Carbon::parse($booking->waktu_selesai)->format('H:s')}})</span></div>
							</td>
							<td class="px-6 py-4">
								{{$booking->kode_pemesanan}}
							</td>
							<td class="px-6 py-4">
								<span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{$booking->status}}</span>
							</td>
							<td class="px-6 py-4">
								Rp{{number_format($booking->total_harga,0,'','.')}}
							</td>
							@if(Auth::user()->hasRole('pegawai'))
							<td class="px-6 py-4 space-x-2">
								<a href="{{route('booking.view', $booking->id)}}" class="font-medium text-gray-600 dark:text-gray-500 hover:underline">View</a>
							</td>
							@endif
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
@endsection