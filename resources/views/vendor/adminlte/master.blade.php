<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>@yield('title_prefix', config('adminlte.title_prefix', ''))
        @yield('title', config('adminlte.title', 'AdminLTE 3'))
        @yield('title_postfix', config('adminlte.title_postfix', ''))
    </title>
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
          type="text/css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.1/css/all.css">

    <link href="{{ asset('css/simple-line-icons.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">

    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    @yield('page_css')
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{ asset('css/components-md.css')}}" rel="stylesheet" id="style_components" type="text/css">
    <link href="{{ asset('css/plugins-md.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/offline.css') }}">
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="{{ asset('css/layout.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/default.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/helper.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/custom.css')}}" rel="stylesheet" type="text/css">
    @include('adminlte::plugins', ['type' => 'css'])
    @yield('adminlte_css_pre')
    @yield('adminlte_css')
    @yield('meta_tags')
</head>
<body class="@yield('classes_body')" @yield('body_data')>

@yield('body')

@yield('ie_js')
<script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.slimscroll.min.js') }}" type="text/javascript"></script>

<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
@yield('page_plugin_js')
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="{{ asset('js/app.min.js') }}" type="text/javascript"></script>
@yield('page_helper_js')
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->

<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<script src="{{ asset('js/layout.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/demo.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/quick-sidebar.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/quick-nav.min.js') }}" type="text/javascript"></script>
@include('adminlte::plugins', ['type' => 'js'])
<script src="{{ asset('vendor/adminlte/dist/js/custom.js') }}"></script>
<script src="{{ asset('vendor/adminlte/dist/js/offline.js') }}"></script>
@yield('adminlte_js')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css"
      integrity="sha512-bYPO5jmStZ9WI2602V2zaivdAnbAhtfzmxnEGh9RwtlI00I9s8ulGe4oBa5XxiC6tCITJH/QG70jswBhbLkxPw=="
      crossorigin="anonymous" referrerpolicy="no-referrer"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js"
        integrity="sha512-AIOTidJAcHBH2G/oZv9viEGXRqDNmfdPVPYOYKGy3fti0xIplnlgMHUGfuNRzC6FkzIo0iIxgFnr9RikFxK+sw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- END THEME LAYOUT SCRIPTS -->
@yield('js')
<!-- Custom JS With PHP Involevd -->
<script type="text/javascript">

    if($('.select2-ajax')[0]){
        select2Ajax(".select2-ajax")
    }

    if($('.select2-ajax-no-limit')[0]){
        select2AjaxNoLimit(".select2-ajax-no-limit")
    }

    if($('.select2-ajax-with-tags')[0]){
        select2AjaxWithTags(".select2-ajax-with-tags")
    }

    function select2Ajax(className){
        $(className).select2({
            allowClear: true,
            placeholder: 'Please Select',
            minimumInputLength: 2,
            selectOnClose: true,
            ajax: {
                url: "{{ route('select2Ajax') }}",
                dataType: "json",
                type: "POST",
                data: function (params) {
                    var queryParameters = {
                        _token: "{{ csrf_token() }}",
                        term: params.term,
                        source: $(this).attr('data-select2-source'),
                        filter: $(this).attr('data-select2-filter')
                    }
                    return queryParameters;
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.text,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });
    }

    function select2AjaxNoLimit(className){
        $(className).select2({
            allowClear: true,
            placeholder: 'Please Select',
            minimumInputLength: 1,
            selectOnClose: true,
            ajax: {
                url: "{{ route('select2Ajax') }}",
                dataType: "json",
                type: "POST",
                data: function (params) {
                    var queryParameters = {
                        _token: "{{ csrf_token() }}",
                        term: params.term,
                        source: $(this).attr('data-select2-source'),
                        filter: $(this).attr('data-select2-filter')
                    }
                    return queryParameters;
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.text,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });
    }

    function select2AjaxWithTags(className){
        $(className).select2({
            allowClear: true,
            placeholder: 'Please Select',
            minimumInputLength: 1,
            selectOnClose: true,
            tags: true,
            ajax: {
                url: "{{ route('select2Ajax') }}",
                dataType: "json",
                type: "POST",
                data: function (params) {
                    var queryParameters = {
                        _token: "{{ csrf_token() }}",
                        term: params.term,
                        source: $(this).attr('data-select2-source'),
                        filter: $(this).attr('data-select2-filter')
                    }
                    return queryParameters;
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.text,
                                id: item.id
                            }
                        })
                    };
                }
            }
        });
    }

    if($('.select2-ajax')[0]){
        $('.select2-ajax').each(function(){
            var select2 = $(this);
            var term = select2.attr('data-select2-value');
            var isMultiple = select2.attr('multiple');

            if(term){
                if(isMultiple){
                    var term = JSON.parse(term);
                    $.each(term, function(i, val){
                        if(!isNull(val)){
                            getValue(select2, val);
                        }
                    });
                }else{
                    getValue(select2, term);
                }
            }
        });
    }

    if($('.select2-ajax-no-limit')[0]){
        $('.select2-ajax-no-limit').each(function(){
            var select2 = $(this);
            var term = select2.attr('data-select2-value');
            var isMultiple = select2.attr('multiple');

            if(term){
                if(isMultiple){
                    var term = JSON.parse(term);
                    $.each(term, function(i, val){
                        if(!isNull(val)){
                            getValue(select2, val);
                        }
                    });
                }else{
                    getValue(select2, term);
                }
            }
        });
    }

    if($('.select2-ajax-with-tags')[0]){
        $('.select2-ajax-with-tags').each(function(){
            var select2 = $(this);
            var term = select2.attr('data-select2-value');
            var isMultiple = select2.attr('multiple');

            if(term){
                if(isMultiple){
                    var term = JSON.parse(term);
                    $.each(term, function(i, val){
                        if(!isNull(val)){
                            getValue(select2, val);
                        }
                    });
                }else{
                    getValue(select2, term);
                }
            }
        });
    }

    function getSelect2Value(select2){
        var returnValue = 0;

        if($(select2).attr('data-select2-value') > 0){
            returnValue = $(select2).attr('data-select2-value');
        }

        if($(select2).val() > 0){
            returnValue = $(select2).val();
        }
        return  returnValue;
    }

    function updateSelect2(select2, value){
        var select2 = $(select2);
        select2.attr('data-select2-value', value);
        if(value){
            getValue(select2, value);
        }
    }

    function getValue(select2, value){
        $.ajax({
            url: "{{ route('select2Ajax') }}",
            dataType: "json",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                term : value,
                source: select2.attr('data-select2-source'),
                filter: select2.attr('data-select2-filter'),
                isDefault: 1
            }
        }).then(function (data) {
            var option = new Option(data[0].text, data[0].id, true, true);
            if(select2.attr('data-select2-trigger') == 0){
                select2.append(option);
            }else{
                select2.append(option).trigger('change');
            }
            select2.trigger({
                type: 'select2:select',
                params: {
                    data: data[0]
                }
            });
        });
    }
</script>
<!-- Custom JS With PHP Involevd -->
</body>
@toastr_js
@toastr_render
</html>