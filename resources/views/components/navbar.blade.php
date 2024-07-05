<nav class="absolute w-full bg-white border-gray-200 dark:bg-gray-900">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4 lg:px-0">
    <a href="{{ route('home.index') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
        <img src="{{ asset('images/logo/logo.png') }}" class="h-6 sm:h-8" alt="Nama" />
        <span class="self-center text-xl sm:text-2xl font-semibold whitespace-nowrap dark:text-white">Gor Griya Srimahi Indah</span>
    </a>
    <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
			@if(Auth::user())
      <button type="button" class="flex text-sm bg-gray-100 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
        <span class="sr-only">Open user menu</span>
        <img class="w-8 h-8 rounded-full" src="{{ asset('images/logo/profile-icon.svg') }}" alt="user photo">
      </button>
      <!-- Dropdown menu -->
      <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600" id="user-dropdown">
        <div class="px-4 py-3">
          <span class="block text-sm text-gray-900 dark:text-white">{{ Auth::user()->name }}</span>
          <span class="block text-sm  text-gray-500 truncate dark:text-gray-400">{{ Auth::user()->username }}</span>
        </div>
        <ul class="py-2 space-y-2" aria-labelledby="user-menu-button">
          <li>
            <a href="{{route('histori-pemesanan.index')}}" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Histori Pemesanan</a>
          </li>
          <li>
            <a href="{{route('penyewaan.list')}}" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Histori Penyewaan</a>
          </li>
          <li>
            <form class="w-full" method="POST" action="{{ route('user.logout') }}">
              @csrf
              @method('delete')
              <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign out</button>
            </form>
          </li>
        </ul>
      </div>
      @else
			<a href="{{ route('login.index') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg px-3 py-2 text-sm dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
				Login
			</a>
			@endif
    </div>
  </div>
</nav>