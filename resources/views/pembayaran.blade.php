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

				<div id="formBukti" class="pt-4">
					<label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload bukti pembayaran</label>
					<input type="hidden" name="kode_pemesanan" value="{{$payments->kode_pemesanan}}">
					<input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="inputBukti" type="file" name="bukti_pembayaran" accept=".jpg,.jpeg,.png" required>
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