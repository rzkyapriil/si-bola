@extends('layouts.app')
@section('title', 'Syarat dan Ketentuan Member - Gor Griya Srimahi Indah')

@section('content')
<div class="w-full min-h-[100dvh]">
	@include('components.navbar')

	<section class="h-[100dvh] bg-center bg-cover bg-no-repeat bg-gray-700 bg-blend-multiply" style="background-image: url({{ asset('images/badminton.jpg') }})">
		<div class="mx-auto max-w-screen-xl h-full flex flex-col items-center justify-center">
			<div class=" flex flex-col gap-4 w-full max-w-xl p-12 bg-blue-300/30 border border-gray-50/50 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700 text-white">
				<h1 class="font-bold text-3xl text-center w-full">
					Tata Cara Menjadi Member
				</h1>
				<div class="px-10">
					<ol class="list-item list-outside list-decimal leading-relaxed text-lg">
						<li>
							<span class="font-bold">Pemesanan Lebih dari 5 Kali</span>. yang melakukan pemesanan lebih dari 5 kali otomatis akan menjadi member GOR.
						</li>
						<li>
							<span class="font-bold">Validasi Pemesanan</span>. Setelah melakukan pemesanan ke-6, status member akan divalidasi secara otomatis oleh sistem kami.

						</li>
						<li>
							<span class="font-bold">Konfirmasi Keanggotaan</span>. Setelah validasi, konfirmasi status member akan ditampilkan melalui notifikasi setelah melakukan pemesanan ke-6.
						</li>
					</ol>
				</div>
				<h1 class="font-bold text-3xl text-white text-center w-full mt-8">
					Keuntungan Menjadi Member
				</h1>
				<div class="px-10">
					<ol class="list-item list-outside list-decimal leading-relaxed text-lg">
						<li>
							Diskon khusus untuk pemesanan berikutnya.
						</li>
						<li>
							Prioritas booking lapangan.
						</li>
						<li>
							Diskon khusus untuk penyewaan barang.
						</li>
						<li>
							Mendapatkan kartu Member.
						</li>
					</ol>
				</div>
			</div>
		</div>
	</section>
</div>
@endsection