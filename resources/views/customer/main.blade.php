<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>@yield('title')</title>
  <!-- MDB icon -->
  <link rel="icon" href="{{ asset('assets/img/favicon.png') }}" type="image/x-icon" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" />
  <!-- Google Fonts Roboto -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" />
  <!-- MDB -->
  <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap-login-form.min.css') }}" />
  <!-- Style.css  -->
  <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  
  @yield('css')
</head>
<body>   
    @yield('content')
    <script type="text/javascript" src="{{ asset('/assets/js/mdb.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js">
    </script>
    @yield('js')
</body>
</html>