<!DOCTYPE html>
<html lang="en">
<meta name="csrf-token" content="{{ csrf_token() }}">

<head>
    @include('head')
</head>

<body > <!--class="animsition" -->

<!-- Header -->
@include('header')

<!-- Cart -->
@include('cart')

@yield('content')

@include('footer')

</body>
</html>
