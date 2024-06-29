@extends('layouts.app')
@section('title', 'Booking - Gor Griya Srimahi Indah')

@section('content')
<div class="w-full min-h-[100dvh]">
	@include('components.navbar')

	<section class="min-h-[100dvh] bg-center bg-cover bg-no-repeat bg-[url('https://plus.unsplash.com/premium_photo-1663039984787-b11d7240f592?q=80&w=3270&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')] bg-gray-700 bg-blend-multiply">
		<div class="mx-auto max-w-screen-xl h-full flex flex-col items-center justify-center">
			<div class="w-full max-w-lg mt-32 mb-20 p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
				<form method="POST" action="{{ route('booking.store') }}" class="flex flex-col gap-6">
					@csrf
					<h5 class="text-xl text-center font-bold text-gray-900 dark:text-white">Booking Lapangan</h5>
					<div>
						<label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
						<input type="text" name="nama" id="nama" placeholder="Masukkan nama" value="{{ Auth::user()->name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required />
						<div class="py-1">
							<span class="label-text-alt text-red-600">{{ $errors->pemesanan->first('nama')}}</span>
						</div>
					</div>
					<div>
						<label for="tanggal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal</label>
						<input type="date" name="tanggal" id="tanggal" placeholder="Masukkan tanggal" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required />
						<div class="py-1">
							<span class="label-text-alt text-red-600">{{ $errors->pemesanan->first('nama')}}</span>
						</div>
					</div>
					<div>
						<label for="lapangan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lapangan</label>
						<select id="lapangan" name="lapangan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
							<option value="" selected disabled>Pilih lapangan</option>
							<option value="Lapangan 1">Lapangan 1</option>
							<option value="Lapangan 2">Lapangan 2</option>
							<option value="Lapangan 3">Lapangan 3</option>
							<option value="Lapangan 4">Lapangan 4</option>
						</select>
						<div class="py-1">
							<span class="label-text-alt text-red-600">{{ $errors->pemesanan->first('lapangan')}}</span>
						</div>
					</div>
					<div>
						<label for="lama_bermain" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Lama bermain</label>
						<ul class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
							<li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
									<div class="flex items-center ps-3">
											<input id="1-jam" type="radio" value="1" name="lama_bermain" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" required>
											<label for="1-jam" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">1 Jam</label>
									</div>
							</li>
							<li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
									<div class="flex items-center ps-3">
											<input id="2-jam" type="radio" value="2" name="lama_bermain" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" required>
											<label for="2-jam" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">2 Jam</label>
									</div>
							</li>
							<li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
									<div class="flex items-center ps-3">
											<input id="3-jam" type="radio" value="3" name="lama_bermain" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" required>
											<label for="3-jam" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">3 Jam</label>
									</div>
							</li>
							<li class="w-full dark:border-gray-600">
									<div class="flex items-center ps-3">
											<input id="4-jam" type="radio" value="4" name="lama_bermain" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" required>
											<label for="4-jam" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">4 Jam</label>
									</div>
							</li>
						</ul>
						<div class="py-1">
							<span class="label-text-alt text-red-600">{{ $errors->pemesanan->first('lama_bermain')}}</span>
						</div>
					</div>
					<div class="flex gap-2.5">
						<div class="w-full">
							<label for="waktu_mulai" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Waktu mulai</label>
							<input type="time" name="waktu_mulai" id="waktu_mulai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required />
							<div class="py-1">
								<span class="label-text-alt text-red-600">{{ $errors->pemesanan->first('waktu_mulai')}}</span>
							</div>
						</div>
						<div class="w-full">
							<label for="waktu_selesai" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Waktu selesai</label>
							<input type="time" name="waktu_selesai" id="waktu_selesai" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required disabled/>
							<div class="py-1">
								<span class="label-text-alt text-red-600">{{ $errors->pemesanan->first('waktu_selesai')}}</span>
							</div>
						</div>
					</div>
					<div class="flex items-end justify-between mb-4">
						<div class="text-lg">Total</div>
						<div id="harga" class="text-xl font-bold">Rp0</div>
					</div>
					<button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Booking</button>
				</form>
			</div>
		</div>
	</section>
</div>

<script>
	let hargaBooking = 50000;

	const harga = document.getElementById('harga');

	function formatRupiah(amount) {
    // Konversi angka ke string dan pisahkan setiap tiga digit dengan titik
    const formattedNumber = amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    return `Rp${formattedNumber}`;
  } 


	function handleRadioChange(event) {
		const waktu_awal = document.getElementById('waktu_mulai');
		const waktu_akhir = document.getElementById('waktu_selesai');
    const selectedValue = event.target.value;

		let timeValue = waktu_awal.value;
    let [hours, minutes] = timeValue.split(':');

		let jam = parseInt(hours)+parseInt(selectedValue)

		if(jam-1 < 10){
			waktu_akhir.value = `0${jam-1}:59`;
			} else {
			waktu_akhir.value = `${jam-1}:59`;
		}

		harga.textContent = formatRupiah(hargaBooking*parseInt(selectedValue));

		console.log(waktu_akhir.value);
  }

  // Get all radio buttons with name="option"
  const radioButtons = document.querySelectorAll('input[name="lama_bermain"]');

  // Add change event listener to each radio button
  radioButtons.forEach((radio) => {
    radio.addEventListener('change', handleRadioChange);
  });

	document.getElementById('waktu_mulai').addEventListener('change', function() {
		const waktu_akhir = document.getElementById('waktu_selesai');
		const lama_bermain = document.querySelector('input[name="lama_bermain"]:checked');

  	let timeValue = this.value;
    let [hours, minutes] = timeValue.split(':');

		let jam = parseInt(hours)+parseInt(lama_bermain.value)

    // Set minutes to '00'
    this.value = `${hours}:00`;

		if(jam-1 < 10){
			waktu_akhir.value = `0${jam-1}:59`;
		} else {
			waktu_akhir.value = `${jam-1}:59`;
		}
		console.log(waktu_akhir.value);
  });
</script>
@endsection