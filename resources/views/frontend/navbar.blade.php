<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{route('dashboard')}}">Divyesh</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <x-nav-link : href="{{route('dashboard')}}" :active="request()->routeIs('dashboard')">
            {{ __('') }}
        </x-nav-link>
        <x-nav-link :href="route('product.index')" :active="request()->routeIs('product.index')">
          {{ __('Product') }}
      </x-nav-link>
          {{-- <a class="nav-link" href="{{route('dashboard')}}">Home <span class="sr-only">(current)</span></a> --}}
        </li>
        <li style="margin-top: 8px;">
            
        </li>
      </ul>
      @if(auth()->check())
      <a href="/order" class="mr-3">my-order</a>

        <a href="/cart">
          <i class="fa fa-shopping-cart" style="font-size:24px"></i>
          @php
              $user = \App\Models\User::with('product')->find(1);
              $product_count = $user->product()->count();
            @endphp 
          @if(isset($product_count))

          <span class='badge badge-warning' id='lblCartCount'>
             
            {{$product_count > 0 ? $product_count : ""}} 
          
          </span>
          @endif
        </a>

        <a class="nav-link" href="{{url('/logout')}}">logout</a>
      @endif
      
    </div>
  </nav>
