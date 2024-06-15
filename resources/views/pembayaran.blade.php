@extends('layouts.app')
@section('title', 'Booking - Gor Griya Srimahi Indah')

@section('content')
<div class="w-full min-h-[100dvh]">
	@include('components.navbar')

	<section class="min-h-[100dvh] bg-center bg-cover bg-no-repeat bg-[url('https://plus.unsplash.com/premium_photo-1663039984787-b11d7240f592?q=80&w=3270&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D')] bg-gray-700 bg-blend-multiply">
		<div class="mx-auto max-w-screen-xl h-full flex flex-col items-center justify-center">
			<form method="POST" action="{{ route('pembayaran.store') }}" enctype="multipart/form-data" class="w-full max-w-lg mt-32 mb-20 p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
				@csrf
				<div class="flex flex-col gap-2.5 w-full border p-2.5 rounded-lg">
					<div class="text-xs flex justify-between">
						<div class="flex gap-2.5">
							<div>{{$payments->tanggal}}</div>
							<div>{{$payments->kode_pemesanan}}</div>
						</div>
						<div class="flex gap-2.5">
							<div>{{$payments->waktu_mulai}}</div>
							<div> -> </div>
							<div>{{$payments->waktu_selesai}}</div>
						</div>
					</div>
					<div class="flex justify-between font-medium">
						<div>{{$payments->nama}}</div>
						<div>{{$payments->lapangan}}</div>
					</div>
				</div>
				<div class="pt-4">
					<label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload bukti pembayaran</label>
					<input type="hidden" name="kode_pemesanan" value="{{$payments->kode_pemesanan}}">
					<input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="file_input" type="file" name="bukti_pembayaran" accept=".jpg,.jpeg,.png" required>
				</div>
				<div class="flex items-end justify-between py-4">
					<div class="text-lg">Total</div>
					<div id="harga" class="text-xl font-bold">Rp{{ number_format($payments->total_harga, 0, '', '.') }}</div>
				</div>
				<button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 w-full dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Bayar</button>
			</form>
		</div>
	</section>
</div>

<script>
	let hargaWeekday = 25000;
	let hargaWeekend = 30000;

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

		if(jam < 10){
			waktu_akhir.value = `0${jam}:00`;
			} else {
			waktu_akhir.value = `${jam}:00`;
		}

		harga.textContent = formatRupiah(hargaWeekday*parseInt(selectedValue));

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
		if(jam < 10){
			waktu_akhir.value = `0${jam}:00`;
		} else {
			waktu_akhir.value = `${jam}:00`;
		}
		console.log(waktu_akhir.value);
  });
</script>
@endsection