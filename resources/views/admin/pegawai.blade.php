@extends('layouts.admin')
@section('title', 'Pegawai')

@section('admin-content')
<div id="tambah_modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
	<div class="relative p-4 w-full max-w-md max-h-full">
			<div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
					<!-- Modal header -->
					<div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
							<h3 class="w-full text-xl text-center font-semibold text-gray-900 dark:text-white">
								Tambah Pegawai
							</h3>
							<button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="tambah_modal">
									<svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
											<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
									</svg>
									<span class="sr-only">Close modal</span>
							</button>
					</div>
					<!-- Modal body -->
					<form method="POST" action="{{route('pegawai.store')}}" class="p-4 md:p-5 flex flex-col gap-4">
						@csrf
						<div>
							<label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
							<input type="text" id="nama" name="nama" maxlength="200" placeholder="Masukkan nama" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
							<span class="text-xs text-red-600">{{ $errors->pegawai->first('nama') }}</span>
						</div>
						<div>
							<label for="jabatan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jabatan</label>
							<select id="jabatan" name="jabatan" class="block w-full p-2 text-xs text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
								<option value="" selected disabled>Pilih Jabatan</option>
								<option value="pengelola lapangan">Pengelola Lapangan</option>
								<option value="petugas kebersihan">Petugas Kebersihan</option>
								<option value="kasir">Kasir</option>
							</select>
							<span class="text-xs text-red-600">{{ $errors->pegawai->first('jabatan') }}</span>
						</div>

						<button type="submit" class="text-nowrap w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
							Tambah
						</button>
					</form>
				</div>
			</div>
</div>

  <div class="flex items-center justify-between mb-6">
		<h1 class="text-2xl font-bold">Pegawai</h1>

		<div class="flex w-1/3">
			<form method="GET" action="{{route('pegawai.index')}}" class="w-full mx-auto">
				<div class="flex">
						<div class="relative w-full">
								<input type="search" name="cari" value="{{$cari}}" class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-s-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500" placeholder="Cari nama jabatan" />
								<button type="submit" class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-blue-700 rounded-e-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
										<svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
												<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
										</svg>
										<span class="sr-only">Search</span>
								</button>
						</div>
				</div>
			</form>
		
			<button type="button" data-modal-target="tambah_modal" data-modal-toggle="tambah_modal" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-3 py-2.5 ms-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
				<svg class="w-5 h-5 fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="fillCurrent"><path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"/></svg>
			</button>
		</div>
	</div>

	<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
		<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
				<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
						<tr>
								<th scope="col" class="px-6 py-3">
									No
								</th>
								<th scope="col" class="px-6 py-3">
									Nama
								</th>
								<th scope="col" class="px-6 py-3">
									Jabatan
								</th>
								<th scope="col" class="px-6 py-3">
									Action
								</th>
						</tr>
				</thead>
				<tbody>
						@forelse($employees as $no => $employee)
						<tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
							<th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
								{{$no+1}}
							</th>
							<td class="px-6 py-4">
								{{$employee->nama}}
							</td>
							<td class="px-6 py-4">
								<div class="uppercase">{{$employee->jabatan}}</div>
							</td>
							<td class="flex px-6 py-4 space-x-2">
								<a href="{{route('pegawai.view', $employee->id)}}" class="font-medium text-gray-600 dark:text-gray-500 hover:underline">View</a>
								<a href="{{route('pegawai.edit', $employee->id)}}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
								<form method="POST" action="{{route('pegawai.destroy', $employee->id)}}">
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
	@include('components.paginator', ['data' => $employees])
@endsection