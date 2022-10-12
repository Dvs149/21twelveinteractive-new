@extends ("frontend.layout")
@section('body')
<div class="container">
    <div class="row">

        @if (!empty($products->count()))
            @foreach ($products as $product)
            {{-- <span id="bnr_image-error" class="error"><br>{{ $product->name }}</span> --}}
            <div class="card" id="prod_{{$product->id}}" style="width: 18rem;margin-right: 30px;margin-top: 30px;">
                <img class="card-img-top" width="100" src="{{ $product->product_image_url }}"  style="height: 250px;" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ $product->detail }}</p>
                <p class="card-text"><b>Price</b> {{ $product->price }}</p>

                    {{-- <button class="btn btn-primary cash-on-delivery" data-id="{{ $product->id }}">COD</button> --}}

                    
                    {{-- <button type="button"  class="btn btn-primary buy"  data-id="{{ $product->id }}"> --}}
                        {{-- <button type="button" class="btn btn-primary" data-id="{{ $product->id }}" data-toggle="modal" data-target="#exampleModal">
                        BUY
                      </button> --}}

                    <div class="btn-group" >
                        <button class="btn btn-primary buy"  data-id="{{ $product->id }}"  data-toggle="modal"data-target="#panel-modal2">Buy</button>
                    </div>
                    <button class="btn btn-danger deleteFormCart" data-id="{{ $product->id }}">Delete</button>
                </div>
            </div>
            @endforeach
        @else
        <div>
            <h1>Nothing in cart</h1>
        </div>
        @endif 
        
    </div>
    
</div >



    <div class="modal modal-nutrition fade full-height from-right" id="panel-modal2" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 class="modal-title">Add Address</h4>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row margin-top-30">
                            <div class="col-md-3">To:</div>
                            <div class="col-md-9">
                                <input type="hidden" id="prod_id" name="product_id" value="">
                                <textarea name="address" id="address" data-id="0" cols="30" rows="5" placeholder="address"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-flat-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-flat-primary sub-add" data-dismiss="modal">Submit</button>
                </div>
            </div>
        </div>


        @endsection
        @section('script')

        <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script>
            $(document).ready(function(){

                $('.buy').on('click',function(){
                    var prod_id = $(this).attr("data-id");
                    $('#prod_id').attr('value', prod_id );
                });


                // $('.buy').modal('show'); 
                $(".sub-add").click(function () {
                    // var cur_div = $(this);

                    var prod_id = $("#prod_id").val();
                    var address = $("#address").val();
                    // alert(prod_id+" : "+ address);
                    var fd = new FormData();
                    fd.append('prod_id', prod_id);
                    fd.append('address', address);
                    if (prod_id) {
                        $.ajax({
                            url: "{{ route('add.order') }}",
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            data: fd,
                            processData: false,
                            contentType: false,
                            type: 'POST',
                            beforeSend: function () {
                                // $('img',cur_element).attr('src',"{{asset('assets/images/loaders/loader8.gif')}}");
                            },
                            success: function (data) {
                                console.log(data.cart_count);

                                $('#prod_'+prod_id).remove();
                                if(data.cart_count){
                                    $('#lblCartCount').html(data.cart_count);
                                } else {
                                    $('#lblCartCount').html('');
                                }
                            },
                            complete: function () {
                                // cur_element.attr('class',"edit");
                            }
                        });
                    }
                    // alert(id);
                });

                $(".deleteFormCart").click(function () {
                    var cur_div = $(this);
                    var id = cur_div.attr("data-id") // will return the string "123";
                    var fd = new FormData();
                    fd.append('id', id);
                    if (id) {
                        $.ajax({
                            url: "{{ route('delete.cart') }}",
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            data: fd,
                            processData: false,
                            contentType: false,
                            type: 'POST',
                            beforeSend: function () {
                                // $('img',cur_element).attr('src',"{{asset('assets/images/loaders/loader8.gif')}}");
                            },
                            success: function (data) {
                                cur_div.closest('.card').remove();
                                if(data){
                                    $('#lblCartCount').html(data);
                                }else {
                                    $('#lblCartCount').html("");
                                }
                            },
                            complete: function () {
                                // cur_element.attr('class',"edit");
                            }
                        });
                    }
                    // alert(id);
                });
    });
        </script>
        @endsection