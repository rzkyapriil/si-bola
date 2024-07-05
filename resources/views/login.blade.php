@extends('layouts.app')
@section('title', 'Login - Gor Griya Srimahi Indah')

@section('content')
<div class="w-full min-h-[100dvh]">
	@include('components.navbar')

	<section class="h-[100dvh] bg-center bg-cover bg-no-repeat bg-gray-700 bg-blend-multiply" style="background-image: url({{ asset('images/badminton.jpg') }})">
		<div class="mx-auto max-w-screen-xl h-full flex flex-col items-center justify-center">
			<div class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
				<form method="POST" action="{{ route('user.login') }}" class="flex flex-col gap-6">
					@csrf
					<h5 class="text-xl font-medium text-gray-900 dark:text-white">Login</h5>
					<div>
						<label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
						<input type="username" name="username" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Masukkan username" required />
					</div>
					<div>
						<label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
						<input type="password" name="password" id="password" placeholder="Masukkan password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required />
					</div>
					{{-- <div class="flex items-start">
						<div class="flex items-start">
							<div class="flex items-center h-5">
								<input id="remember" type="checkbox" value="" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" required />
							</div>
							<label for="remember" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Remember me</label>
						</div>
						<a href="#" class="ms-auto text-sm text-blue-700 hover:underline dark:text-blue-500">Lost Password?</a>
					</div> --}}
					<button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Login</button>
					<div class="text-sm font-medium text-gray-500 dark:text-gray-300">
						Belum registrasi? <a href="{{ route('register.index') }}" class="text-blue-700 hover:underline dark:text-blue-500">Buat akun</a>
					</div>
				</form>
			</div>
		</div>
	</section>
</div>
@endsection