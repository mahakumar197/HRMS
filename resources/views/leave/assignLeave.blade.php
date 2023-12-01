@extends('layouts.app')

@section('page_title')
<title>Assign Leave</title>
@endsection

@section('content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>{{ __('Assign Leave') }}</h3>
                </div>

            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-body">
                        @if($errors->any())

                        @foreach ($errors->all() as $error)
                        <div class="alert alert-danger dark alert-dismissible fade show" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-down">
                                <path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path>
                            </svg>
                            <p> {{$error}}</p>
                            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
                        </div>
                        @endforeach

                        @endif
                        @if(Session::has('error2'))
                        <div class="alert alert-danger dark alert-dismissible fade show" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-down">
                                <path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path>
                            </svg>
                            <p> {{session::get('error2')}}</p>
                            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
                        </div>
                        @endif

                        @if(Session::has('message'))
                        <div class="alert alert-success dark alert-dismissible fade show" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up">
                                <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
                            </svg>
                            <p> {{session::get('message')}}</p>
                            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
                        </div>
                        @endif
                        @if(Session::has('message1'))
                        <div class="alert alert-danger dark alert-dismissible fade show" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up">
                                <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
                            </svg>
                            <p> {{session::get('message')}}</p>
                            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
                        </div>
                        @endif

                        <div class="form theme-form projectcreate">
                            <form action="{{url ('assignleave') }}" method="post" id='leave' autocomplete="off">
                                @csrf
                                <div class="tab" style="display: block;">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label class="col-form-label">Employee Name*</label>
                                                <select class="js-example-basic-single col-sm-12 {{ $errors->has('name') ? ' has-error' : ''}} emp" name="user_id" id="employee">
                                                    <option value="">Select</option>
                                                    @foreach($employees as $emp)
                                                    <option value="{{$emp->id}}" {{ (collect(old('name'))->contains($emp->id)) ? 'selected':'' }}>{{$emp->employee_code}} - {{$emp->name}} {{$emp->last_name}}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('name'))
                                                <div class="text-danger">{{ $errors->first('name') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <!-- <div class="mb-3 col-md-6">
                                            <label for="name">Employee Name*</label>
                                            <div class="form-group">
                                                <input type="text" name="name" id='employee_search' class="typeahead form-control input-lg" placeholder="Employee Name" />
                                            </div>-->
                                        <!--<input class="form-control" id="name" type="text" value="{{Auth::user()->name}}" required="required" readonly>-->
                                        <!--</div>-->

                                        <!--<div class="mb-3 col-md-6">
                                            <label for="name">Employee Code*</label>-->
                                        <!--<input class=" form-control" type="text" data-language="en" id="designation" readonly>-->
                                        <!--<input class="form-control" type="text" id="emp_code" value='' required="required" placeholder="Employee Code" readonly>
                                            <input type="hidden" name="user_id" value='' id='emp_id' class="form-control input-lg" />
                                        </div>-->
                                    </div>

                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="name">Leave Type*</label>
                                            <select class="form-select form-control" name="leave_type_id">
                                                <option>Select</option>
                                                @foreach ($leave_type as $lt)
                                                @if($lt->name == 'CL')
                                                <option value="{{$lt->id}}">Casual Leave</option>
                                                @elseif($lt->name == 'PL')
                                                <option value="{{$lt->id}}">Privilege Leave</option>
                                                @elseif($lt->name == 'SL')
                                                <option value="{{$lt->id}}">Sick Leave</option>

                                                @endif
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <div class="col">
                                                <div class="m-t-15 m-checkbox-inline custom-radio-ml">
                                                    <div class="form-check form-check-inline radio radio-primary halfday">
                                                        <input class="form-check-input" id="radioinline3" type="radio" name="fullDay" value="0">
                                                        <label class="form-check-label mb-0" for="radioinline3">Half Day </label>
                                                    </div>
                                                    <div class="form-check form-check-inline radio radio-primary">
                                                        <input class="form-check-input" id="radioinline1" type="radio" name="fullDay" value="1" checked>
                                                        <label class="form-check-label mb-0" for="radioinline1">Single Day </label>
                                                    </div>
                                                    <div class="form-check form-check-inline radio radio-primary">
                                                        <input class="form-check-input" id="radioinline2" type="radio" name="fullDay" value="2">
                                                        <label class="form-check-label mb-0" for="radioinline2">Multi Day </label>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>

                                        <div class="row ">
                                            <div class="mb-3 col-md-6 ">
                                                <label for="startDate" id="sd">From Date*</label>
                                                <input class="form-control datepicker-here leave_picker" id="startDate" type="text" data-position="bottom right" readonly placeholder="DD-MM-YYYY" data-language="en" required="required" name="startDate">
                                            </div>


                                            <div class="mb-3 col-md-6 showCta ">
                                                <label for="toDate">To Date*</label>
                                                <input class=" form-control datepicker-here leave_picker " id="toDate" type="text" data-position="bottom right" readonly placeholder="DD-MM-YYYY" data-language="en" name="endDate">
                                            </div>

                                        </div>

                                        <div class="mb-3 col-md-12">
                                            <label for="name">Leave Reason*</label>
                                            <input class="form-control" id="name" name="leaveReason" type="text" required="required">
                                        </div>

                                    </div>
                                    <div>

                                        <div class="btn-mb mt-4">
                                            <div class="text-right"> <button class="btn btn-primary me-3" type="submit"> Save </button>
                                                <a onclick="resetForm()" class="btn btn-danger me-3">Reset</a> <a href="{{route('manageleave.index')}}" class="btn btn-secondary me-3">Cancel</a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Container-fluid Ends-->

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-xl-4 col-lg-4 ">
                <div class="card social-widget-card">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <h4>Leave Availability</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row" id="balance">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- footer start-->
@endsection

@section('script')
<script>
    $('input[type="radio"]').change(function() {
        if (this.checked) {
            $('#sd').text('Date');
            $('.showCta').toggle(this.id === 'radioinline2');
        }

    }).change();
</script>

<script>
    $("form").submit(function() {
        if ($('#radioinline1').is(':checked')) {
            $('#toDate').val($('#startDate').val());
        }
        if ($('#radioinline3').is(':checked')) {
            $('#toDate').val($('#startDate').val());
        }
    });
</script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

<!-- Script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
    // CSRF Token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    /*   $(document).ready(function() {

           $("#employee_search").autocomplete({
               source: function(request, response) {

                   // Fetch data
                   $.ajax({

                       headers: {
                           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                       },
                       url: "{{route('leavefetch')}}",
                       type: 'post',
                       dataType: "json",
                       data: {
                           _token: CSRF_TOKEN,
                           search: request.term
                       },
                       success: function(data) {
                           response(data);
                       }
                   });
               },
               select: function(event, ui) {
                   // Set selection
                   $('#employee_search').val(ui.item.label); // display the selected text        
                   $("#emp_id").attr("value", ui.item.value);
                   $('#emp_code').val(ui.item.label2);
                   // save selected id to input

                   return false;
               }
           });


       });
</script>*/

<script>
    function resetForm() {
        document.getElementById("leave").reset();
    }
</script>
<script>
    $(".emp").change(function() {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        const empId = $(this).val();
        $.ajax({
            type: "get",
            url: "{{ route('getempleavebalance') }}",
            data: {
                employeeId: empId,
            },
            success: function(result) {
                $("#balance").empty();

                console.log(result);
                if (result && result?.status === "success") {
                    $.each(result.data, function(index, value) {
                        const balance = '<div class="col text-center" ><h6 class="font-roboto">' + index + '</h6><h5 class="counter mb-0 font-roboto font-primary mt-1">' + value + '</h5></div>';
                        $("#balance").append(balance);
                    });
                }
            },
            error: function(result) {
                console.log("error", result);
            },
        });
    });

    $(function() {

        $('#type').change(function() {
            if ($('#type').val() == 2) {
                $('.halfday').hide();
            } else {

                $('.halfday').show();
            }
        });
    });
</script>
<script src="{{asset('assets/js/select2/select2.full.min.js')}}"></script>
<script src="{{asset('assets/js/select2/select2-custom.js')}}"></script>
@endsection