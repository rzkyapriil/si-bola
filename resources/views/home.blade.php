@extends('layouts.app')
@section('title', 'Gor Griya Srimahi Indah')
@php
	use Carbon\Carbon;
@endphp
@section('content')
<div class="w-full min-h-[100dvh]">
	@include('components.navbar')

	<section class="h-[100dvh] bg-center bg-cover bg-no-repeat bg-gray-700 bg-blend-multiply" style="background-image: url({{ asset('images/badminton.jpg') }})">
		<div class="mx-auto max-w-screen-xl h-full flex flex-col items-start justify-center px-4 lg:px-0">
			<h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-white md:text-5xl lg:text-6xl">
				Gor Griya Srimahi Indah 
			</h1>
			<p class="mb-8 text-lg font-normal text-gray-300 lg:text-xl w-full lg:w-[900px]">
				Selamat datang di Gor Griya Srimahi Indah! Temukan dan pesan lapangan badminton favorit Anda dengan beberapa klik saja. Nikmati kemudahan akses, pemesanan real-time, dan berbagai metode pembayaran yang aman.
			</p>
			<div class="flex flex-row sm:justify-center">
				<a href="{{ route('home.booking') }}" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
					Booking lapangan
					<svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
						<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
					</svg>
				</a>
				<a href="#Jadwal" class="flex justify-center items-center py-3 px-5 ms-4 text-base font-medium text-center text-gray-700 rounded-lg bg-white hover:bg-gray-300 focus:ring-4 focus:ring-blue-300">
					Jadwal
				</a>
			</div>
		</div>
	</section>
	<section id="Jadwal" class="w-full min-h-[100dvh] pt-12">
		<div class="mx-auto max-w-screen-xl h-full flex flex-col items-center justify-center p-4 lg:p-0">
			<div class="relative flex items-center justify-center mb-6 w-full">
				<div class="absolute left-0 font-mono">
					<div class="flex flex-col">
						<div class="flex justify-between text-xl font-semibold">{{Carbon::parse($tanggal)->translatedFormat('d')}} <span>/</span> {{Carbon::parse($tanggal)->translatedFormat('m')}}</div>
						<div class="text-sm">{{Carbon::parse($tanggal)->translatedFormat('Y-D')}}</div>
					</div>
				</div>
				<h1 class="flex flex-col sm:flex-row items-start sm:items-center gap-1.5 text-xl sm:text-3xl font-bold font-mono">
					Jadwal Penggunaan Lapangan
				</h1>
				<form method="GET" action="{{route('home.index')}}" class="absolute right-0">
					<div class="flex">
						<input type="date" name="tanggal" value="{{$tanggal}}" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
						<button type="submit" class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
							<svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
									<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
							</svg>
							<span class="sr-only">Search</span>
						</button>
					</div>
				</form>
			</div>
			<div class="flex flex-col w-full">
				@forelse($timetables as $no => $timetable)
				<div class="flex items-center justify-between w-full px-3 py-4 border-b border-black hover:bg-gray-50">
					<div class="font-mono font-thin text-lg">
						{{Carbon::parse($timetable->waktu_mulai)->format('H:i')}} 
					</div>
					<div class="font-mono text-blue-700 font-semibold text-2xl">
						{{$timetable->lapangan}}
					</div>
					<div class="font-mono font-thin text-lg">
						{{Carbon::parse($timetable->waktu_selesai)->format('H:i')}} 
					</div>
				</div>
				@empty
				<div class="flex items-center justify-between w-full py-3 border-y border-black">
					<div class="font-mono text-blue-700 font-semibold text-2xl text-center w-full">
						Data tidak ada!
					</div>
				</div>
				@endforelse
			</div>
		</div>

		<div class="mx-auto max-w-screen-xl h-full flex flex-col items-center justify-center p-4 mt-12 lg:p-0 group">
			<div class="relative flex items-center justify-center mb-6 w-full">
				<h1 class="flex flex-col sm:flex-row items-start sm:items-center gap-1.5 text-xl sm:text-3xl font-bold font-mono">
					Sewa Alat
				</h1>
			</div>
			<div class="flex flex-col gap-4 w-full">
				@forelse($inventories as $no => $inventory)
				<div class="relative flex items-center justify-center w-full py-3 border-b border-black hover:bg-gray-50">
					<div class="absolute left-4 font-mono font-thin text-lg">
						{{$inventory->nama}}
					</div>
					<div class="font-mono text-blue-700 font-semibold text-2xl w-fit">
						<img src="{{asset($inventory->foto)}}" alt="{{$inventory->nama}}" class="h-20 hover:h-40 transition-all ease-in-out object-cover">
					</div>
					
					<div class="absolute right-4 flex gap-4">
						<div class="font-mono font-thin text-lg">
							25k/jam
						</div>
						<a href="{{route('penyewaan.form', ['inventaris' => $inventory->id])}}" title="sewa" class="text-blue-700 font-mono font-semibold text-lg hidden group-hover:flex hover:underline">
							Sewa
						</a>
					</div>
				</div>
				@empty
				<div class="flex items-center justify-between w-full py-3 border-y border-black">
					<div class="font-mono text-blue-700 font-semibold text-2xl text-center w-full">
						Data tidak ada!
					</div>
				</div>
				@endforelse
			</div>
	</section>
</div>

@endsection