<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html" lang="id" data-theme="light">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport"
      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title')</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  </head>

  <body>
    @include('components.alert')
    @yield('content')

    <script>
      var alert = document.getElementById('alert');
        
        if(alert != null) {
          setTimeout(function() {
            removeElement(alert);
          }, 3000);
        }
        
        function removeElement(element) {
          element.parentNode.removeChild(element);
        }
    </script>
  </body>
</html>