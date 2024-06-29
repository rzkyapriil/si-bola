@extends('layouts.admin')
@section('title', $employee->nama . " ($employee->jabatan)")

@php
	use Carbon\Carbon;
@endphp

@section('admin-content')
<div id="tambah_modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
	<div class="relative p-4 w-full max-w-md max-h-full">
			<div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
					<!-- Modal header -->
					<div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
							<h3 class="w-full text-xl text-center font-semibold text-gray-900 dark:text-white">
								Gaji {{$employee->nama}}
							</h3>
							<button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="tambah_modal">
									<svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
											<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
									</svg>
									<span class="sr-only">Close modal</span>
							</button>
					</div>
					<!-- Modal body -->
					<form method="POST" action="{{route('gaji.store')}}" class="p-4 md:p-5 flex flex-col gap-4">
						@csrf
						<input type="hidden" name="pegawai_id" value="{{$employee->id}}">
						<div>
							<label for="tanggal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal</label>
							<input type="date" id="tanggal" name="tanggal" value="{{Carbon::now()->format('Y-m-d')}}" maxlength="200" placeholder="Masukkan nama" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
							<span class="text-xs text-red-600">{{ $errors->gaji->first('tanggal') }}</span>
						</div>
						<div>
							<label for="gaji" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gaji</label>
							<input type="number" min="100000" step="100000" id="gaji" name="gaji" placeholder="Masukkan gaji" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
							<span class="text-xs text-red-600">{{ $errors->gaji->first('gaji') }}</span>
						</div>

						<button type="submit" class="text-nowrap w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
							Tambah
						</button>
					</form>
				</div>
			</div>
</div>

<div class="flex flex-col items-center">
	<div class="flex mb-4">
		<h1 class="text-2xl font-bold w-full">Lihat Pegawai</h1>		
	</div>
	
	<div class="flex flex-col gap-4 w-full max-w-screen-sm">
		<div class="flex items-center justify-between border rounded-lg p-2.5">
			<div>{{$employee->nama}}</div>
			<div class="text-xs uppercase">{{$employee->jabatan}}</div>
		</div>

		<button type="button" data-modal-target="tambah_modal" data-modal-toggle="tambah_modal" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
			Gaji
		</button>

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
										Gaji
									</th>
									<th scope="col" class="px-6 py-3">
										Action
									</th>
							</tr>
					</thead>
					<tbody>
							@forelse($employee_salaries as $no => $employee_salary)
							<tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
								<th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
									{{$no+1}}
								</th>
								<td class="px-6 py-4">
									{{$employee_salary->tanggal}}
								</td>
								<td class="px-6 py-4">
									Rp{{number_format($employee_salary->gaji,0,'','.')}}
								</td>
								<td class="flex px-6 py-4 space-x-2">
									<form method="POST" action="{{route('gaji.destroy', $employee_salary->id)}}">
										@csrf @method('delete')
										<button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">Delete</button>
									</form>
								</td>
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
		@include('components.paginator', ['data' => $employee_salaries])
	</div>
</div>
@endsection