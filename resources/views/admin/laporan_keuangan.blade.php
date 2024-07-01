@extends('layouts.admin')
@section('title', 'Laporan Keuangan')

@php
		use Carbon\Carbon;
@endphp

@section('admin-content')
<div class="flex flex-col lg:flex-row items-center justify-center mt-14 mb-4 gap-4 lg:gap-0">
	<h1 class="text-2xl font-bold w-fit lg:w-full">Laporan Keuangan (Gaji Pegawai)</h1>

	<form method="GET" action="{{ route('laporan.keuangan') }}" class="flex w-full gap-2.5">
		<select id="inputFilter" type="text" placeholder="filter" name="filter" class="block p-2.5 w-full lg:w-fit text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-e-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500">
				<option value="" selected disabled>Pilih Filter</option>
				<option value="perminggu" {{$filter == "perminggu" ? 'selected':''}}>Perminggu</option>
				<option value="perbulan" {{$filter == "perbulan" ? 'selected':''}}>Perbulan</option>
				<option value="pertahun" {{$filter == "pertahun" ? 'selected':''}}>Pertahun</option>
		</select>
		<input id="inputWeek" type="week" name="minggu" value="{{$minggu}}" class="hidden p-2.5 w-full lg:w-fit text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-e-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500" required/>
		<input id="inputMonth" type="month" name="bulan" value="{{$bulan}}" class="hidden p-2.5 w-full lg:w-fit text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-e-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500" required/>
		<input id="inputYear" type="number" placeholder="Masukkan tahun" name="tahun" min="2000" value="{{$tahun}}" class="hidden p-2.5 w-full lg:w-fit text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-e-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500" required/>
		<button type="submit" class="p-2.5 text-sm font-medium h-full text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
				<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 -960 960 960" fill="currentColor">
						<path d="M380-320q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l224 224q11 11 11 28t-11 28q-11 11-28 11t-28-11L532-372q-30 24-69 38t-83 14Zm0-80q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z" />
				</svg>
		</button>
	</form>
</div>

<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
	<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
		<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
			<tr>
				<th scope="col" class="px-6 py-3">
					No
				</th>
				<th scope="col" class="px-6 py-3">
					Tanggal
				</th>
				<th scope="col" class="px-6 py-3">
					Nama
				</th>
				<th scope="col" class="px-6 py-3">
					Jabatan
				</th>
				<th scope="col" class="px-6 py-3">
					Gaji
				</th>
			</tr>
		</thead>
		<tbody>
			@forelse ($finances as $no => $finance)
			<tr>
				<th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
					{{$no+1}}
				</th>
				<td class="px-6 py-4">
					{{Carbon::parse($finance->tanggal)->translatedFormat('d F Y')}}
				</td>
				<td class="px-6 py-4">
					{{$finance->nama}}
				</td>
				<td class="px-6 py-4">
					{{$finance->jabatan}}
				</td>
				<td class="px-6 py-4">
					Rp{{number_format($finance->gaji,0,'','.')}}
				</td>
			</tr>
			@empty
			<tr>
				<td class="text-center bg-gray-100 py-3" colspan="5">-- Data kosong --</td>
			</tr>
			@endforelse
			@if($finances->count() != 0)
			<tr class="bg-gray-100">
				<td class="font-bold text-center py-3" colspan="4">Total</td>
				<td class="font-medium px-6 py-3">Rp{{number_format($finances->sum('gaji'),0,'','.')}}</td>
			</tr>
			@endif
		</tbody>
	</table>
</div>
@include('components.paginator', ['data' => $finances])

<script>
	$(document).ready(function () {
		$('#inputWeek').prop('disabled', true)
		$('#inputMonth').prop('disabled', true)
		$('#inputYear').prop('disabled', true)

		if($('#inputFilter').val() == 'perminggu'){
				$('#inputWeek').removeClass('hidden');
				$('#inputWeek').prop('disabled', false)
			} else if($('#inputFilter').val() == 'perbulan') {
				$('#inputMonth').removeClass('hidden');
				$('#inputMonth').prop('disabled', false)
			} else if($('#inputFilter').val() == 'pertahun') {
				$('#inputYear').removeClass('hidden');
				$('#inputYear').prop('disabled', false)
			}
		
		$('#inputFilter').change(function() {
			$('#inputWeek').prop('disabled', true)
			$('#inputMonth').prop('disabled', true)
			$('#inputYear').prop('disabled', true)
			$('#inputWeek').addClass('hidden');
			$('#inputMonth').addClass('hidden');
			$('#inputYear').addClass('hidden');

			if($('#inputFilter').val() == 'perminggu'){
				$('#inputWeek').removeClass('hidden');
				$('#inputWeek').prop('disabled', false)
			} else if($('#inputFilter').val() == 'perbulan') {
				$('#inputMonth').removeClass('hidden');
				$('#inputMonth').prop('disabled', false)
			} else if($('#inputFilter').val() == 'pertahun') {
				$('#inputYear').removeClass('hidden');
				$('#inputYear').prop('disabled', false)
			}
		});
    });
</script>
@endsection