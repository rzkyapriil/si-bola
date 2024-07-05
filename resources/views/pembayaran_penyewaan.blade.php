@extends('layouts.app')
@section('title', 'Pembayaran - Gor Griya Srimahi Indah')

@php
		use Carbon\Carbon;
@endphp

@section('content')
<div class="w-full min-h-[100dvh]">
	@include('components.navbar')

	<section class="min-h-[100dvh] bg-center bg-cover bg-no-repeat bg-gray-700 bg-blend-multiply" style="background-image: url({{ asset('images/badminton.jpg') }})">
		<div class="mx-auto max-w-screen-xl h-full flex flex-col items-center justify-center">
			<form method="POST" action="{{ route('penyewaan.update', $rental->penyewaan_id) }}" enctype="multipart/form-data" class="w-full max-w-lg mt-32 mb-20 p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
				@csrf @method('put')
				<div class="flex flex-col gap-2.5 w-full border p-2.5 rounded-lg">
					<div class="flex justify-between gap-2.5 text-nowrap text-xs border-b pb-1.5">
						<div>{{Carbon::parse($rental->tanggal_mulai)->translatedFormat('d F Y')}}</div>
						<div class="flex gap-2.5 text-nowrap">
							<div>{{Carbon::parse($rental->tanggal_mulai)->translatedFormat('H:i')}}</div>
							<div> -> </div>
							<div>{{Carbon::parse($rental->tanggal_selesai)->translatedFormat('H:i')}}</div>
						</div>
					</div>
					<div class="flex font-medium w-full">
						<div>{{$rental->nama}}</div>
					</div>
				</div>
				<div class="pt-4">
					<label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Pilih metode pembayaran</label>
					<ul class="w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
							<li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
									<div class="flex items-center ps-3">
											<input id="list-radio-license" type="radio" value="transfer" name="metode_pembayaran" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" checked>
											<label for="list-radio-license" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Transfer</label>
									</div>
							</li>
							<li class="w-full border-gray-200 rounded-t-lg dark:border-gray-600">
									<div class="flex items-center ps-3">
											<input id="list-radio-passport" type="radio" value="cash" name="metode_pembayaran" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
											<label for="list-radio-passport" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Cash</label>
									</div>
							</li>
					</ul>
				</div>
				<input type="hidden" name="status" value="menunggu konfirmasi">
				<div id="formBukti" class="pt-4">
					<label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload bukti pembayaran</label>
					<input type="hidden" name="kode_pemesanan" value="{{$rental->kode_pemesanan}}">
					<input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="inputBukti" type="file" name="bukti_pembayaran" accept=".jpg,.jpeg,.png" required>
				</div>
				<div class="flex items-end justify-between py-4">
					<div class="text-lg">Total</div>
					<div id="harga" class="text-xl font-bold">Rp{{ number_format($rental->total_harga, 0, '', '.') }}</div>
				</div>
				<button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 w-full dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Bayar</button>
			</form>
		</div>
	</section>
</div>

<script>
	$(document).ready(function(){
		$("input[name='metode_pembayaran']").change(function(){
      var selectedValue = $("input[name='metode_pembayaran']:checked").val();

      if(selectedValue == 'transfer')
			{
				$("#formBukti").removeClass("hidden")
				$("#inputBukti").prop('disabled', false);
			} else {
				$("#formBukti").addClass("hidden")
				$("#inputBukti").prop('disabled', true);
			}
    });
  });
</script>
@endsection