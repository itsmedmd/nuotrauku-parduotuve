<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <title>Image Shop</title>
      <link rel="stylesheet" href="{{ asset('css/app.css') }}">
      <link rel="stylesheet" href="{{ asset('css/navigation.css') }}">
      @yield('styles')
   </head>
   <body>
      <div class="app">
            <div class="nav-container">
              <nav>
                 <ul>
                    <li>
                       <a href="/">Home</a>
                    </li>
                    <li>
                       <a href="CreatedImagesListView">Created Images List</a>
                    </li>
                 </ul>
              </nav>
            </div>
            @yield('content')
      </div>
      @yield('js')
   </body>
</html>