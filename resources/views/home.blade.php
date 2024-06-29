@extends('layouts.app')
@section('title', 'Gor Griya Srimahi Indah')
@php
	use Carbon\Carbon;
@endphp
@section('content')
<div class="w-full min-h-[100dvh]">
	@include('components.navbar')

	<section class="h-[100dvh] bg-center bg-cover bg-no-repeat bg-[url('https://plus.unsplash.com/premium_photo-1663039984787-b11d7240f592?q=80&w=3270&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')] bg-gray-700 bg-blend-multiply">
		<div class="mx-auto max-w-screen-xl h-full flex flex-col items-start justify-center">
			<h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl">
				Gor Griya Srimahi Indah
			</h1>
			<p class="mb-8 text-lg font-normal text-gray-300 lg:text-xl w-[900px]">
				Selamat datang di Gor Griya Srimahi Indah! Temukan dan pesan lapangan badminton favorit Anda dengan beberapa klik saja. Nikmati kemudahan akses, pemesanan real-time, dan berbagai metode pembayaran yang aman.
			</p>
			<div class="flex flex-col space-y-4 sm:flex-row sm:justify-center sm:space-y-0">
				<a href="{{ route('home.booking') }}" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
					Booking lapangan
					<svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
						<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
					</svg>
				</a>
				<a href="#Jadwal" class="inline-flex justify-center items-center py-3 px-5 ms-4 text-base font-medium text-center text-gray-700 rounded-lg bg-white hover:bg-gray-300 focus:ring-4 focus:ring-blue-300">
					Jadwal
				</a>
			</div>
		</div>
	</section>
	<section id="Jadwal" class="w-full min-h-[100dvh] py-8">
		<div class="mx-auto max-w-screen-xl h-full flex flex-col items-center justify-center">
			<div class="flex items-center justify-between mb-6 w-full">
				<h1 class="flex items-center gap-1.5 text-2xl font-extrabold w-full">
					Jadwal Lapangan <span class="text-base font-medium">({{Carbon::parse($tanggal)->translatedFormat('d F Y')}})</span>
				</h1>
				<form method="GET" action="{{route('home.index')}}" class="flex">
					<input type="date" name="tanggal" value="{{$tanggal}}" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
					<button type="submit" class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
						<svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
								<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
						</svg>
						<span class="sr-only">Search</span>
				</button>
				</form>
			</div>
			<div class="relative overflow-x-auto shadow-md sm:rounded-lg w-full">
				<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
						<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
								<tr>
										<th scope="col" class="px-6 py-1.5">
											No
										</th>
										<th scope="col" class="px-6 py-1.5">
											Lapangan
										</th>
										<th scope="col" class="px-6 py-1.5">
											Waktu
										</th>
										<th scope="col" class="px-6 py-1.5">
											Nama
										</th>
								</tr>
						</thead>
						<tbody>
								@forelse($timetables as $no => $timetable)
								<tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
									<th scope="row" class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
										{{$no+1}}
									</th>
									<td class="px-6 py-2">
										{{$timetable->lapangan}}
									</td>
									<td class="px-6 py-2">
										{{Carbon::parse($timetable->waktu_mulai)->format('H:s')}} -> {{Carbon::parse($timetable->waktu_selesai)->format('H:s')}}
									</td>
									<td class="px-6 py-2">
										{{$timetable->nama}}
									</td>
								</tr>
								@empty
								<tr>
									<td colspan="4" class="px-6 py-2 text-center">
										Data Kosong
									</td>
								</tr>
								@endforelse
						</tbody>
				</table>
			</div>
		</div>

		<div class="mx-auto max-w-screen-xl h-full flex flex-col items-center justify-center mt-8">
			<div class="flex items-center justify-between mb-6 w-full">
				<h1 class="text-2xl font-extrabold w-full">
					Inventaris
				</h1>
			</div>
			<div class="relative overflow-x-auto shadow-md sm:rounded-lg w-full">
				<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
						<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
								<tr>
										<th scope="col" class="px-6 py-1.5">
												No
										</th>
										<th scope="col" class="px-6 py-1.5">
											Nama
										</th>
										<th scope="col" class="px-6 py-1.5">
											Harga
										</th>
										<th scope="col" class="px-6 py-1.5">
											Status
										</th>
								</tr>
						</thead>
						<tbody>
								@forelse($inventories as $no => $inventory)
								<tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
									<th scope="row" class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
										{{$no+1}}
									</th>
									<td class="px-6 py-2">
										{{$inventory->nama}}
									</td>
									<td class="px-6 py-2">
										{{$inventory->harga}}
									</td>
									<td class="px-6 py-2">
										{{$inventory->status}}
									</td>
								</tr>
								@empty
								<tr>
									<td colspan="4" class="px-6 py-2 text-center">
										Data Kosong
									</td>
								</tr>
								@endforelse
						</tbody>
				</table>
			</div>
		</div>
	</section>
</div>

@endsection