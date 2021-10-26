@extends('layouts.layoutfront')
@section('title', 'My Account')
@section('content')
    <div class="row  mt-5">
        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
            <div class="card h-100">
                <div class="card-body">
                    <div class="account-settings">
                        <div class="user-profile">
                            <div class="user-avatar">
                                <img src="https://bootdey.com/img/Content/avatar/avatar7.png"
                                                          alt="Maxwell Admin" width="90%">
                            </div>
                            <h5 class="user-name">{{ auth('web')->user()->name}}</h5>
                            <h6 class="user-email">{{ auth('web')->user()->email}}</h6>
                        </div>
                        <div class="about mt-1">
                            <h5>Account Type</h5>
                            <hr>
                            <p>{{@$data->account_type->name}}</p>
                        </div>
                        <div class="about mt-1">
                            <h5>Account Status</h5>
                            <hr>
                            <p>{{@$data->account_status->name}}</p>
                        </div>
                        <div class="about mt-1">
                            <h5>Dorms/Houses</h5>
                            <hr>
                            @foreach(@$data->account_groups->entities as $group)
                                <p>{{@$group->name}}</p>
                            @endforeach
                        </div>
                        <div class="about mt-1">
                            <h5>Activated Service</h5>
                            <hr>
                            @if( count(@$data->account_services->entities) == 0)
                             <p class="text-danger">You do not have any active service.</p>
                            @endif
                        @foreach(@$data->account_services->entities as $service)
                                <p>{!! $service->service->name ." - &pound;".$service->service->amount/100 !!}
                                <br>
                                    <a class="delete-service text-danger font-weight-bold" href="javascript:;" data-id="{{$service->id}}" class="text-danger font-weight-bold">DELETE</a>
                                </p>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row gutters">
                        <div class="col-12">
                            <h4 class="mb-2 text-primary">Address</h4>
                        </div>
                        @foreach(@$data->addresses->entities as $address)
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Address Type</label>
                                    <input type="text" class="form-control" disabled value="{{$address->addressable_type}}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Serviceable</label>
                                    <input type="text" class="form-control" disabled value="{{$address->serviceable}}">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Type</label>
                                    <input type="text" class="form-control" disabled value="{{$address->type}}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Base Location</label>
                                    <textarea  class="form-control" disabled>{{$address->line2}}</textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Room/House Number</label>
                                    <textarea  class="form-control" disabled>{{$address->line1}}</textarea>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>City</label>
                                    <input type="text" class="form-control" disabled value="{{$address->city}}">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Country</label>
                                    <input type="text" class="form-control" disabled value="United Kingdom">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>State</label>
                                    <input type="text" class="form-control" disabled value="{{\App\Helpers\Common::subdivision("value",$address->subdivision)}}">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label>Zip</label>
                                    <input type="text" class="form-control" disabled value="{{$address->zip}}">
                                </div>
                            </div>
                        @endforeach
                        <div class="col-12">
                            <h4 class="mb-2 text-primary">Credit Cards</h4>
                            <table class="table table-hover table-condensed">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Type</th>
                                    <th>Name on Card</th>
                                    <th>Card Number</th>
                                    <th>Expiration Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach(@$data->credit_cards->entities as $card)
                                    <tr>
                                        <td>{{$card->id}}</td>
                                        <td>{{$card->credit_card_type}}</td>
                                        <td>{{$card->name_on_card}}</td>
                                        <td>**** **** **** {{$card->masked_number}}</td>
                                        <td>{{$card->expiration_month }} / {{$card->expiration_year }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <hr>
                        </div>
                        <div class="col-12">
                            <h4 class="mb-2 text-primary">Debits</h4>
                            <table class="table table-hover table-condensed">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Created At</th>
                                    <th>Invoice id</th>
                                    <th>Amount</th>
                                    <th>Service Id</th>
                                    <th>Service name</th>
                                    <th>Type</th>
                                    <th>Number of months</th>
                                    <th>Quantity</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach(@$data->debits->entities as $debit)
                                    <tr>
                                        <td>{{$debit->id}}</td>
                                        <td>{{$debit->created_at}}</td>
                                        <td>{{$debit->invoice_id}}</td>
                                        <td>&pound; {{$debit->amount / 100}}</td>
                                        <td>{{$debit->service_id }}</td>
                                        <td>{{$debit->service_name }}</td>
                                        <td>{{$debit->type }}</td>
                                        <td>{{$debit->number_of_months }}</td>
                                        <td>{{$debit->quantity }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <hr>
                        </div>
                        <div class="col-12">
                            <h4 class="mb-2 text-primary">Credits</h4>
                            <table class="table table-hover table-condensed">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Created At</th>
                                    <th>Invoice id</th>
                                    <th>Amount</th>
                                    <th>Creditable Type</th>
                                    <th>Creditable Id</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach(@$data->credits->entities as $credit)
                                    <tr>
                                        <td>{{$credit->id}}</td>
                                        <td>{{$credit->created_at}}</td>
                                        <td>{{$credit->invoice_id}}</td>
                                        <td>&pound; {{$credit->amount / 100}}</td>
                                        <td>{{$credit->creditable_type }}</td>
                                        <td>{{$credit->creditable_id }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-12">
                            <h4 class="mb-2 text-primary">Payments</h4>
                            <hr>
                            <table class="table table-hover table-condensed">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Created At</th>
                                    <th>Amount</th>
                                    <th>Amount Remaining</th>
                                    <th>Credit Card Id</th>
                                    <th>Payment Type</th>
                                    <th>Successful</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach(@$data->payments->entities as $payment)
                                    <tr>
                                        <td>{{$payment->id}}</td>
                                        <td>{{$payment->payment_datetime}}</td>
                                        <td>&pound; {{$payment->amount / 100}}</td>
                                        <td>&pound; {{$payment->amount_remaining / 100}}</td>
                                        <td>{{$payment->credit_card_id }}</td>
                                        <td>{{$payment->payment_type }}</td>
                                        <td>{{$payment->successful }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <hr>
                        </div>

                        <div class="col-12">
                            <h4 class="mb-2 text-primary">Invoices</h4>

                            <table id="cart" class="table table-hover table-condensed">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Invoice Date</th>
                                    <th>Due Date</th>
                                    <th>Charged</th>
                                    <th>Paid</th>
                                    <th>Balance</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach(@$data->invoices->entities as $invoice)
                                    <tr>
                                        <td>{{$invoice->id}}</td>
                                        <td>{{$invoice->date}}</td>
                                        <td>{{$invoice->due_date}}</td>
                                        <td>&pound; {{$invoice->total_debits / 100}}</td>
                                        <td>&pound; {{$invoice->remaining_due == 0 ?  $invoice->total_debits / 100 :($invoice->total_debits - $invoice->remaining_due)/100}}</td>
                                        <td>&pound; {{$invoice->remaining_due / 100}} {{ $invoice->remaining_due==0 ? "PAID" : "" }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <hr>
                        </div>
                        <div class="col-12">
                            <h4 class="mb-2 text-primary">Activated Services</h4>

                            <table id="cart" class="table table-hover table-condensed">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach(@$data->account_services->entities as $service)
                                    <tr>
                                        <td>{{$service->id}}</td>
                                        <td>{{$service->service->name}}</td>
                                        <td>&pound; {{$service->service->amount/100}}</td>
                                        <td><a class="delete-service text-danger font-weight-bold" href="javascript:;" data-id="{{$service->id}}">DELETE</a> </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <hr>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(".delete-service").click(function () {
            var id = $(this).attr('data-id');
            if(confirm("Do You really want to delete this service?")){
                var data ={
                    'id':id,
                    '_token': "{{csrf_token()}}"
                };
                $.ajax({
                    url: "{{route('remove.service')}}",
                    dataType: "json",
                    type: "POST",
                    data: data
                }).then(function (data) {
                    console.log(data);
                    location.href = '{{route('myaccount')}}';
                }).fail(function (error) {
                    console.log(error);
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
        })
    </script>
@endsection