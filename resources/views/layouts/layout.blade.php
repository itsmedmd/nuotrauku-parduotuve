<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src='https://cdn.plot.ly/plotly-2.11.1.min.js'></script>
      <title>Image Shop</title>
      <link rel="stylesheet" href="{{ asset('css/app.css') }}">
      <link rel="stylesheet" href="{{ asset('css/navigation.css') }}">
      <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
      <link rel="stylesheet" href="{{ asset('css/action-confirmation-form.css') }}">
      @yield('styles')
   </head>
   <body>
      <div class="app">
            <nav class="main-nav">
               <ul>
                  <li>
                     <a href="/">Home</a>
                  </li>
                  <li>
                     <a href="/ImagesListView">Images For Sale</a>
                  </li>
                  <li>
                     <a href="/CreatedImagesListView">Created Images</a>
                  </li>
                  <li>
                     <a href="/ownedimages/1">Owned Images</a>
                  </li>
                  <li>
                     <a href="/CollectionsListView">Image Collections</a>
                  </li>
                  <li>
                     <a href="/AwardsListView">Awards</a>
                  </li>
               </ul>
            </nav>
            @yield('content')
      </div>
      @yield('js')
   </body>
</html>