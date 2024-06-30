@extends('layouts.admin')
@section('title', 'Edit Inventaris')

@section('admin-content')
<div class="flex flex-col items-center">
	<div class="flex mb-4">
		<h1 class="text-2xl font-bold w-full">Edit Inventaris</h1>		
	</div>
	<form method="POST" action="{{ route('inventaris.update', $inventory->id) }}" enctype="multipart/form-data" class="flex flex-col gap-2.5 w-full max-w-xl">
		@csrf
		@method('put')
		<div>
			<label for="foto" class="block text-sm font-medium text-gray-900 dark:text-white">Foto</label>
			<img src="{{asset($inventory->foto)}}" alt="{{$inventory->nama}}" class="py-4">
			<input class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" type="file" name="foto" accept=".jpg,.png,.jpeg">
			<span class="text-xs text-red-600">{{ $errors->inventaris->first('foto') }}</span>
		</div>
		<div>
			<label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
			<input type="text" id="nama" name="nama" value="{{$inventory->nama}}" maxlength="200" placeholder="Masukkan nama" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
			<span class="text-xs text-red-600">{{ $errors->inventaris->first('nama') }}</span>
		</div>
		<div>
			<label for="harga" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Harga</label>
			<input type="number" id="harga" name="harga" value="{{$inventory->harga}}" placeholder="Masukkan harga" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
			<span class="text-xs text-red-600">{{ $errors->inventaris->first('harga') }}</span>
		</div>
		<div>
			<label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
			<select id="status" name="status" class="block w-full p-2 text-xs text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
				<option value="" selected disabled>Pilih Status</option>
				<option value="layak" {{$inventory->status == "layak" ? "selected":""}}>Layak</option>
				<option value="tidak layak" {{$inventory->status == "tidak layak" ? "selected":""}}>Tidak Layak</option>
			</select>
			<span class="text-xs text-red-600">{{ $errors->inventaris->first('status') }}</span>
		</div>
	
		<button type="submit" class="px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
			Edit
		</button>
	</form>
</div>
@endsection