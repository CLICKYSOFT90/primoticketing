@extends('layouts.layoutfront')
@section('css')
    <style type="text/css">
        .credit_card .field {
            font-size: 20px;
            margin-top: 10px;
            display: inline-block;
        }

        .credit_card .cvc.field {
            margin-left: 15px;
        }

        .credit_card input {
            font-family: monospace;
            font-size: 20px;
            padding: 7px;
            border-radius: 7px;
            border: 1px solid #ccc;
        }

        .credit_card .error input,.credit_card .error select, .credit_card .error textarea {
            color: red;
            border: 1px solid red;
        }

        .credit_card #submit {
            font-size: 16px;
            margin-top: 20px;
            padding: 7px;
            margin-bottom: 30px;
            border-radius: 7px;
            border: 1px solid #555;
            color: #eee;
            background-color: #555;
            cursor: pointer;
        }

    </style>
@endsection
@section('title', 'Checkout')
@section('content')
    <table id="cart" class="table table-hover table-condensed mt-5">
        <thead>
        <tr>
            <th style="width:50%">Product</th>
            <th style="width:10%">Price</th>
            <th style="width:8%">Quantity</th>
            <th style="width:22%" class="text-center">Subtotal</th>
        </tr>
        </thead>
        <tbody>
        @php $total = 0 @endphp
        @if(session('cart'))
            @foreach(session('cart') as $id => $details)
                @php $total += $details['amount'] * $details['quantity'] @endphp
                <tr data-id="{{ $id }}">
                    <td data-th="Product">
                        <div class="row">
                            <div class="col-sm-3 hidden-xs"><img src="{{ asset('image/isp.jpg')}}" width="100"
                                                                 height="100" class="img-responsive"/></div>
                            <div class="col-sm-9">
                                <h4 class="nomargin">{{ $details['name'] }}</h4>
                                <p class="mt-3">
                                    <strong>Upload
                                        Speed: </strong>{{ $details['upload_speed_kilobits_per_second']/1000 }} Mbps<br>
                                    <strong>Download
                                        Speed: </strong>{{ $details['download_speed_kilobits_per_second']/1000 }}
                                    Mbps<br>
                                    <strong>Frequency: </strong>{{ $details['billing_frequency'] }} month<br>
                                    <strong>Payment Mode: </strong>{{ $details['application'] }}<br>
                                    <strong>Type: </strong>{{ $details['type'] }}<br>
                                </p>
                            </div>
                        </div>
                    </td>
                    <td data-th="Price">&pound; {{ $details['amount'] }}</td>
                    <td data-th="Quantity">
                        <input type="number" disabled="" value="{{ $details['quantity'] }}"
                               class="form-control quantity"/>
                    </td>
                    <td data-th="Subtotal" class="text-center">&pound; {{ $details['amount'] * $details['quantity'] }}</td>
                </tr>
            @endforeach
        @endif
        </tbody>
        <tfoot>
        <tr>
            <td colspan="5" class="text-right"><h3><strong>Total &pound;{{ $total }}</strong></h3></td>
        </tr>
        <tr>
            <td colspan="5" class="text-right">
                <a href="{{ url('/') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Continue Shopping</a>
            </td>
        </tr>
        </tfoot>
    </table>
    <form method="post" id="payment_form">
    <div class="row credit_card field">

            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="col-md-12">
                <h4>Billing Address</h4>
                <hr>
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                    <label for="name" class="col-md-12">Name *</label>
                    <div class="col-md-12">
                        <input type="text" value="{{auth('web')->user()->name}}"  name="name" class="form-control" id="billing_name"></input>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                    <label for="name" class="col-md-12">Address Line 1*</label>
                    <div class="col-md-12">
                        <textarea class="form-control" name="line1" id="billing_address_line1">{{$address->line1}}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group row">
                    <label for="name" class="col-md-12">Line2 </label>
                    <div class="col-md-12">
                        <textarea class="form-control" name="line2" id="line2">{{$address->line2}}</textarea>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group row">
                    <label class="col-md-12">Country *</label>
                    <div class="col-md-12">
                        <select class="form-control" name="country" id="country">
                            <option value="">Select Country</option>
                            <option value="GB" selected>United Kingdom</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group row">
                    <label class="col-md-12">City * </label>
                    <div class="col-md-12">
                        <input type="text" class="form-control" name="city" id="city" value="{{$address->city}}">
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group row">
                    <label class="col-md-12">State/Province *</label>
                    <div class="col-md-12">
                        <select class="form-control" name="subdivision" id="subdivision">
                            <option value="">Select</option>
                            @foreach(\App\Helpers\Common::subdivision() as $stateKey=>$stateValue)
                                <option  {{$stateValue == $address->subdivision ? "selected" : "" }} value="{{$stateValue}}">{{$stateKey}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group row">
                    <label class="col-md-12">Zip code * </label>
                    <div class="col-md-12">
                        <input type="text" class="form-control" name="zip" id="zip" value="{{$address->zip}}">
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <h4>Payment Detail</h4>
                <hr>
            </div>
            <div class="col-md-3">
                <div class="form-group row">
                    <label class="col-md-12">Name on Card * </label>
                    <div class="col-md-12">
                        <input type="text" class="form-control"   name="name_on_card" value="{{auth('web')->user()->name}}" id="name_on_card">
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group row">
                    <label class="col-md-12">Card Number * </label>
                    <div class="col-md-12">
                        <input placeholder="---- ---- ---- ----" type="tel" size="19" type="text" class="form-control"  name="card_number" value="4242424242424242" id="ccnum">
                        <div>
                            <small>type: <strong id="ccnum-type">invalid</strong></small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group row">
                    <label class="col-md-12">Expiration * </label>
                    <div class="col-md-12">
                        <input class="form-control" style="width: 100px" placeholder="-- / --" size=5" type="tel" name="expiry" value="12/24" id="expiry">
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group row">
                    <label class="col-md-12">CVC * </label>
                    <div class="col-md-12">
                        <input class="form-control" placeholder="---" size="4" type="tel" name="cvc" value="123" id="cvc">
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <button id="submit" class="btn btn-group-lg float-left">Make Payment</button>
                <div id="result" class="emoji float-left ml-4 mt-4"></div>
            </div>

    </div>
    </form>

@endsection

@section('scripts')
    <script src="{{ asset('js/payform.min.js') }}"></script>
    <script type="text/javascript">
        $("#payment_form").submit(function(e){
            e.preventDefault();
            return false;
        });

        (function () {
            var ccnum = document.getElementById('ccnum'),
                type = document.getElementById('ccnum-type'),
                name_on_card = document.getElementById('name_on_card'),
                expiry = document.getElementById('expiry'),
                cvc = document.getElementById('cvc'),
                billing_name = document.getElementById('billing_name'),
                billing_address_line1 = document.getElementById('billing_address_line1'),
                country = document.getElementById('country'),
                city = document.getElementById('city'),
                subdivision = document.getElementById('subdivision'),
                zip = document.getElementById('zip'),
                submit = document.getElementById('submit'),
                result = document.getElementById('result');

            payform.cardNumberInput(ccnum);
            payform.expiryInput(expiry);
            payform.cvcInput(cvc);

            ccnum.addEventListener('input', updateType);

            submit.addEventListener('click', function () {
                var valid = [],
                    expiryObj = payform.parseCardExpiry(expiry.value);
                var name_on_card_validate = true;
                var billing_name_validate = true;
                var billing_address_line1_validate = true;
                var country_validate = true;
                var city_validate = true;
                var subdivision_validate = true;
                var zip_validate = true;
                if(name_on_card.value==""){
                    name_on_card_validate = false;
                }
                if(billing_name.value==""){
                    billing_name_validate = false;
                }
                if(billing_address_line1.value==""){
                    billing_address_line1_validate = false;
                }
                if(country.value==""){
                    country_validate = false;
                }
                if(city.value==""){
                    city_validate = false;
                }
                if(subdivision.value==""){
                    subdivision_validate = false;
                }
                if(zip.value==""){
                    zip_validate = false;
                }

                valid.push(fieldStatus(name_on_card, name_on_card_validate));
                valid.push(fieldStatus(billing_name, billing_name_validate));
                valid.push(fieldStatus(billing_address_line1, billing_address_line1_validate));
                valid.push(fieldStatus(country, country_validate));
                valid.push(fieldStatus(city, city_validate));
                valid.push(fieldStatus(subdivision, subdivision_validate));
                valid.push(fieldStatus(zip, zip_validate));
                valid.push(fieldStatus(ccnum, payform.validateCardNumber(ccnum.value)));
                valid.push(fieldStatus(expiry, payform.validateCardExpiry(expiryObj)));
                valid.push(fieldStatus(cvc, payform.validateCardCVC(cvc.value, type.innerHTML)));

                if(valid.every(Boolean)){
                    var data = $('#payment_form').serialize();
                    $("#submit").attr('disabled',true);
                    $("#result").text("Please wait, we are processing..");
                    $.ajax({
                        url: "{{route('payment')}}",
                        dataType: "json",
                        type: "POST",
                        data: data
                    }).then(function (data) {
                        console.log(data);
                        location.href = '{{route('front')}}';
                    }).fail(function (error) {
                        console.log(error);
                        $("#submit").removeAttr('disabled');
                        $("#result").text(error.responseJSON.message);
                        if(error.responseJSON.hasOwnProperty('errors')){
                            var error_msg = "";

                            for(var prop in error.responseJSON.errors){

                                $(error.responseJSON.errors[prop]).each(function (val,msg){

                                    error_msg+=''+msg+"<br>";
                                });
                            }
                            $(".error_div_schedule").html(error_msg);
                            $(".error_div_schedule").show();


                        }else{
                            alert(error.responseJSON.message);
                        }

                    });

                }


                //result.className = 'emoji ' + (valid.every(Boolean) ? 'valid' : 'invalid');
            });

            function updateType(e) {
                var cardType = payform.parseCardType(e.target.value);
                type.innerHTML = cardType || 'invalid';
            }


            function fieldStatus(input, valid) {
                if (valid) {
                    removeClass(input.parentNode, 'error');
                } else {
                    addClass(input.parentNode, 'error');
                }
                return valid;
            }

            function addClass(ele, _class) {
                if (ele.className.indexOf(_class) === -1) {
                    ele.className += ' ' + _class;
                }
            }

            function removeClass(ele, _class) {
                if (ele.className.indexOf(_class) !== -1) {
                    ele.className = ele.className.replace(_class, '');
                }
            }
        })();

    </script>
@endsection