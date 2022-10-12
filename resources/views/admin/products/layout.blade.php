<!DOCTYPE html>
<html>
<head>
    <title>21 twelve interactive</title>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
    
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
            {{-- <a class="nav-link" href="#">Link</a> --}}
            <a class="nav-link" href="{{ route('products.create') }}"> Create New Product</a>
            </li>
        </ul>
        
        <form class="form-inline my-2 my-lg-0" method="POST" action="{{ route('admin.logout') }}">
            @csrf

            <x-dropdown-link :href="route('admin.logout')"
                    onclick="event.preventDefault();
                                this.closest('form').submit();">
                {{ __('Log Out') }}
            </x-dropdown-link>
        </form>
        </div>
    </nav>
    @yield('content')
</div>
    
</body>
</html>