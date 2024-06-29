@extends('layouts.admin')
@section('title', 'Edit Pegawai')

@section('admin-content')
<div class="flex flex-col items-center">
	<div class="flex mb-4">
		<h1 class="text-2xl font-bold w-full">Edit Pegawai</h1>		
	</div>
	<form method="POST" action="{{ route('pegawai.update', $employee->id) }}" class="flex flex-col gap-2.5 w-full max-w-xl">
		@csrf
		@method('put')
		<div>
			<label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
			<input type="text" id="nama" name="nama" value="{{$employee->nama}}" maxlength="200" placeholder="Masukkan nama" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
			<span class="text-xs text-red-600">{{ $errors->pegawai->first('nama') }}</span>
		</div>
		<div>
			<label for="jabatan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jabatan</label>
			<select id="jabatan" name="jabatan" class="block w-full p-2 text-xs text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
        <option value="" selected disabled>Pilih Jabatan</option>
				<option value="pengelola lapangan" {{$employee->jabatan == "pengelola lapangan" ? "selected":""}}>Pengelola Lapangan</option>
				<option value="petugas kebersihan" {{$employee->jabatan == "petugas kebersihan" ? "selected":""}}>Petugas Kebersihan</option>
				<option value="kasir" {{$employee->jabatan == "kasir" ? "selected":""}}>Kasir</option>
			</select>
			<span class="text-xs text-red-600">{{ $errors->pegawai->first('role') }}</span>
		</div>
	
		<button type="submit" class="px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
			Edit
		</button>
	</form>
</div>
@endsection