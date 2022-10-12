@extends ("frontend.layout")
@section('body')
<div class="container">
    <div class="row">

        @if (!empty($orders->count()))
            @foreach ($orders as $order)
            <div class="card"  style="width: 18rem;margin-right: 30px;margin-top: 30px;">
                <img class="card-img-top" width="100" src="{{ $order->product->product_image_url }}"  style="height: 250px;" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">Address</h5>
                    <p class="card-text">{{ $order->address->address }}</p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><b>Name:</b> {{ $order->product->name }}</li>
                    <li class="list-group-item"><b>Details:</b> {{ $order->product->detail }}</li>
                    <li class="list-group-item"><b>price:</b>{{ $order->product->price }}</li>
                </ul>
            </div>
            @endforeach
            @else
            <div>
                <h1>Nothing in Order</h1>
            </div>
            @endif 
        
    </div>
    
</div >



    


        @endsection
        @section('script')

        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script>
            $(document).ready(function(){

            });
        </script>
        @endsection