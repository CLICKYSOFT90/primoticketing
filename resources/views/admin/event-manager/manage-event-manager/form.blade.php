@extends('adminlte::page')
@section('title', 'Global Setting')
@section('content_header')
@stop
@section('content')
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption font-green">
                <i class="fas fa-plus-square font-green"></i>
                <span class="caption-subject bold uppercase">Create Event</span>
            </div>
        </div>
        <div class="portlet-body">
            <form method="post" enctype="multipart/form-data" action="#" name="eventForm" id="eventForm" class="eventForm">
                {{csrf_field()}}
                @if($model->exists)
                    <input type="hidden" name="id" id="id" value="{{ $model->id }}">
                @endif
                <div id="error" class="form-group"></div>
                <button type="button" class="btn blue btn-outline right save_btn event">Save</button>
                <h4 class="font-green bold uppercase">Event Details</h4>
                <div class="formfieldholder">
                    <label>Event Name</label>
                    <input type="text" name="name" value="{{old('event',$model->name)}}" required="">
                </div>
                <div class="formfieldholder">
                    <label>Event Category</label>
                    <select name="event_type_id" id="event_type_id">
                        <option value="">Please Select</option>
                        @foreach($eventType as $rec)
                            <option value="{{$rec->id}}" {{ old('event_type_id',$model->event_type_id) == $rec->id ? 'selected' : '' }}>
                                {{ $rec->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="formfieldholder">
                    <label>Event Photo</label>
                    @if($model->exists)
                    <div><img src="{{ asset("storage/uploads/$model->event_photo")}}" width="100" height="100"></div>
                    @endif
                    <input type="file" name="event_photo_file" id="event_photo_file">
                </div>
                <div class="formfieldholder">
                    <label>Event Gallery</label>
                    @if($model->exists)
                        <div><img src="{{ asset("storage/uploads/$model->event_gallery")}}" width="100" height="100"></div>
                    @endif
                    <input type="file" name="event_gallery_file" id="event_galleryfile">
                </div>
                <br>
                <br>
                <br>
                @include('admin.event-manager.manage-event-manager._partials.child-events')
                <div class="clearfix"></div>
                @include('admin.event-manager.manage-event-manager._partials.ticket-types')
                <div class="clearfix"></div>
            </form>
        </div>
        <!-- /.portlet -->
    </div>
@stop

@section('css')

@stop
@section('js')
    <script>
        jQuery('.datepicker').datetimepicker({
            format:'m/d/Y H:i',
            //startDate:'2021/11/03',
            //inline:false,
            lang:'en'
        });

        // Login Function
        $(document).ready(function () {
            //onchange();
            setTimeout(function () {
                $("body #event_type_id").trigger("change");
            },1000);

            //alert("dd");

            $("body").on("click", ".save_btn.event", function (e) {


                var fd = new FormData();
                $('body #eventForm input[type="file"]').each(function(){
                    //code
                    var input = document.getElementById($(this).attr('id'));
                    fd.append($(this).attr('name'),!input.files[0]);
                });

                var other_data = $('#eventForm').serializeArray();
                $.each(other_data,function(key,input){
                    fd.append(input.name,input.value);
                    console.log(input.name,input.value);
                });

                $.easyAjax({
                    url: "{{ route('eventManager.store') }}",
                    type: "POST",
                    data: fd,
                    container: ".eventForm",
                    messagePosition: "inline",
                    file: true
                });
            });
            $("body").on("click", ".add_event", function (e) {
                //$("body .datepicker").datetimepicker('remove'); //detach
                jQuery('.datepicker').datetimepicker({
                    format:'m/d/Y H:i',
                    lang:'en'
                });

            });

            $("body").on("change", ".ticket_type_dropdown", function (e) {
                if($(this).val()==""){
                   $(this).parent().parent().find('.default_price').val("");
                   $(this).parent().parent().find('.default_limit').val("");
                }else{
                    var data_limit = $('option:selected', this).attr('data-limit');
                    var data_price = $('option:selected', this).attr('data-price');
                    $(this).parent().parent().find('.default_price').val(data_price);
                    $(this).parent().parent().find('.default_limit').val(data_limit);
                }

            });
            $("body").on("change", "#event_type_id", function (e) {
                var ticketTypes = "{{$tickets}}";
                ticketTypes = JSON.parse(ticketTypes.replace(/&quot;/g,'"'));

                if($(this).val() != ""){
                    $.ajax({
                        url: "{{ route('getEventTypeTicket') }}",
                        dataType: "json",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            event_type_id : $(this).val()
                        }
                    })
                     .then(function (data) {
                         if(data.length > 0){
                             var html = "<option value=''>Select</option>";
                             //var selected ="";

                             for(var i=0; i< data.length ; i++){
                                 var default_limit =  data[i].default_limit;
                                 var default_price =  data[i].default_price;
                                 var selected ="";
                                 html+='<option '+selected+' data-limit="'+default_limit+'" data-price="'+default_price+'" value="'+data[i].id+'">' +
                                    data[i].name +
                                    '</option>';
                             }

                             $("body .ticket_type_dropdown")
                                 .find('option')
                                 .remove()
                                 .end()
                                 .append(html)
                                 .trigger('change');

                             $( "body .ticket_type_dropdown" ).each(function() {
                                 //console.log( $(this).options);
                                 var usedIndex = [];
                                 var parentRef = $(this);
                                 var selected = "";
                                  $(this).find('option').each(function () {
                                      if($(this).val()!="") {
                                          var removeIndex = ticketTypes.map(function (item) {
                                              return parseInt(item.ticket_type_id);
                                          }).indexOf(parseInt($(this).val()));

                                          if (removeIndex !== -1) {

                                              if(jQuery.inArray( removeIndex, usedIndex )===-1) {
                                                 // console.log(removeIndex);
                                                  default_limit = ticketTypes[removeIndex].ticket_default_limit;
                                                  default_price = ticketTypes[removeIndex].ticket_default_price;
                                                  selected = 'selected="selected"';
                                                  $(this).attr('data-limit', default_limit);
                                                  $(this).attr('data-price', default_price);
                                                  $(this).attr('selected', selected);
                                              }
                                              usedIndex.push(removeIndex);

                                          }
                                          //console.log($(this).val());
                                          //console.log($(this).attr('data-limit'));
                                      }
                                  });
                                  $(parentRef).trigger("change");

                             });
                             /*var removeIndex = ticketTypes.map(function(item) {return parseInt(item.ticket_type_id); }).indexOf(parseInt(data[i].id));

                             if (removeIndex !== -1) {

                                 console.log("found"+ jQuery.inArray( removeIndex, usedIndex ));
                                 console.log("ri"+removeIndex);
                                 if(jQuery.inArray( removeIndex, usedIndex )===-1) {
                                     default_limit = ticketTypes[removeIndex].ticket_default_limit;
                                     default_price = ticketTypes[removeIndex].ticket_default_price;
                                     selected = 'selected="selected"';
                                 }

                                 usedIndex.push(removeIndex);
                                 //ticketTypes.splice(removeIndex, 1);
                             }*/


                         }else{
                             $("body .ticket_type_dropdown")
                                 .find('option')
                                 .remove()
                                 .end()
                                 .append('<option value="">No ticket type found against selected event category.</option>').trigger('change');
                         }

                     });

                }else{
                    $(".ticket_type_dropdown")
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">Please first select Event Category</option>').trigger('change');
                }

            });

        })
    </script>
@stop
@section('ie_js')
    <script src="{{ asset('js/ie8.fix.min.js') }}"></script>
@stop
@section('page_plugin_js')
    <script src="{{ asset('js/jquery.backstretch.min.js') }}"></script>
@stop
@section('page_helper_js')
    <script src="{{ asset('js/helper.js') }}" type="text/javascript"></script>
@stop

@section('plugins.Datatables', true)

