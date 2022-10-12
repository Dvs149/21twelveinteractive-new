@extends("frontend.layout")
@section('body')
<div class="container">
    <div class="row">

        @if ($products)
        @foreach ($products as $product)
        {{-- <span id="bnr_image-error" class="error"><br>{{ $product->name }}</span> --}}
        <div class="card" style="width: 18rem;margin-right: 30px;margin-top: 30px;">
            <img class="card-img-top" width="100" src="{{ $product->product_image_url }}"  style="height: 250px;" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">{{ $product->name }}</h5>
                <p class="card-text">{{ $product->detail }}</p>
                <p class="card-text"><b>Price</b> {{ $product->price }}</p>
                <button class="btn btn-primary addToCart" data-id="{{ $product->id }}">Add to cart</button>
            </div>
        </div>
        @endforeach
        @endif 
        
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script>
    $(document).ready(function(){
        $(".addToCart").click(function(){
            var id = $(this).attr("data-id") // will return the string "123";
            var fd = new FormData();
            fd.append( 'id', id );
            if(id){
                $.ajax({
                    url:"{{ route('add.cart') }}",
                    headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: fd,
                    processData: false,
                    contentType: false,
                    type: 'POST',
                    beforeSend: function(){
                        // $('img',cur_element).attr('src',"{{asset('assets/images/loaders/loader8.gif')}}");
                    },
                    success: function ( data ) {
                        // console.log(data.status);
                        if(data.status){
                            $('#lblCartCount').html(data.cart_number);
                        } else {
                            alert(data.duplicate)
                        }
                    },
                    complete: function(){
                        // cur_element.attr('class',"edit");
                    }
                });
            }
            // alert(id);
        });
    });
</script>
@endsection