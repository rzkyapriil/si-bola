@extends('layouts.app')
@section('title', 'Gor Griya Srimahi Indah')

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
			</div>
		</div>
	</section>
</div>
@endsection