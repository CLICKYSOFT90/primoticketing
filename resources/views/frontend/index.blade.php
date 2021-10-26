@extends('layouts.layoutfront')
@section('content')   
<div class="row mt-5">
    @foreach($products as $product)
        @if($product->active == 0)
            @continue
        @endif
        <div class="col-xs-12 col-sm-6 col-md-3">
            <div class="thumbnail">
                <img src="{{ asset('image/isp.jpg')}}" alt="">
                <div class="caption">
                    <h4 class="text-center mt-3">{{ $product->name }}</h4>
                    <p class="mt-3">
                        <strong>Upload Speed: </strong>{{ $product->upload_speed_kilobits_per_second/1000 }} Mbps<br>
                        <strong>Download Speed: </strong>{{ $product->download_speed_kilobits_per_second/1000 }} Mbps<br>
                        <strong>Frequency: </strong>{{ $product->billing_frequency }} month<br>
                        <strong>Payment Mode: </strong>{{ $product->application }}<br>
                        <strong>Type: </strong>{{ $product->type }}<br>
                    </p>
                    <h5 class="text-center mt-3">&pound; {{ $product->amount }}</h5>
                    <p class="btn-holder"><a href="{{ route('add.to.cart', $product->sonar_id) }}" class="btn btn-warning btn-block text-center" role="button">Add to cart</a> </p>
                </div>
            </div>
        </div>
    @endforeach
        <div class="col-xs-12 col-sm-6 col-md-3">
            <div class="thumbnail">
                <img src="{{ asset('image/isp.jpg')}}" alt="">
                <div class="caption">
                    <h4 class="text-center mt-3">DNS</h4>

                    <h5 class="text-center mt-3"> </h5>
                    <p class="btn-holder">
                        <a href="" class="btn btn-warning btn-block text-center" data-toggle="modal" data-target="#modalLoginForm">Request Info</a>
                </div>
            </div>
        </div>
</div>
<div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold">Request Info</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <div class="md-form mb-5">
                    <input type="email" id="defaultForm-email" class="form-control validate">
                    <label data-error="wrong" data-success="right" for="defaultForm-email">Your email</label>
                </div>
                <div class="md-form mb-5">
                    <input type="text" class="form-control validate">
                    <label data-error="wrong" data-success="right" for="defaultForm-email">Name</label>
                </div>
                <div class="md-form mb-5">
                    <textarea class="form-control validate"></textarea>
                    <label data-error="wrong" data-success="right" for="defaultForm-email">Message</label>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">Send message</button>
            </div>
        </div>
    </div>
</div>

@endsection