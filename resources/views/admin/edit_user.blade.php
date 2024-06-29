@extends('layouts.admin')
@section('title', 'Edit User')

@section('admin-content')
<div class="flex flex-col items-center">
	<div class="flex mb-4">
		<h1 class="text-2xl font-bold w-full">Edit User</h1>		
	</div>
	<form method="POST" action="{{ route('user.update', $user->id) }}" class="flex flex-col gap-2.5 w-full max-w-xl">
		@csrf
		@method('put')
		<div>
			<label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
			<input type="text" id="name" name="name" value="{{$user->name}}" maxlength="200" placeholder="Masukkan nama" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
			<span class="text-xs text-red-600">{{ $errors->user->first('name') }}</span>
		</div>
		<div>
			<label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
			<input type="text" id="username" name="username" value="{{$user->username}}" maxlength="200" placeholder="Masukkan username" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
			<span class="text-xs text-red-600">{{ $errors->user->first('username') }}</span>
		</div>
		<div>
			<label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
			<select id="role" name="role" class="block w-full p-2 text-xs text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
				<option value="" selected disabled>Pilih Role</option>
        @foreach ($roles as $role)
				<option value="{{$role->name}}" {{$user->role == $role->name ? "selected":""}}>{{$role->name}}</option>
        @endforeach
			</select>
			<span class="text-xs text-red-600">{{ $errors->user->first('role') }}</span>
		</div>
		<div>
			<label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
			<input type="password" id="password" name="password" placeholder="Masukkan password" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-xs focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
			<span class="text-xs {{ $errors->user->first('password') == null ? 'text-gray-400':'text-red-600' }}">{{ $errors->user->first('password') == null ? 'Masukkan jika ingin mengganti password': $errors->user->first('password') }}</span>
		</div>
	
		<button type="submit" class="px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
			Edit
		</button>
	</form>
</div>
@endsection