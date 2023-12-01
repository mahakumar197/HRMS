@extends('layouts.app')

@section('page_title')
<title>Apply Leave</title>
@endsection

@section('content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>{{ __('Apply Leave') }}</h3>
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

                        @if($ml_exists != 'true')
                        <div class="form theme-form projectcreate">

                            <form action="{{url ('leave') }}" method="post" id='leave' autocomplete="off">
                                @csrf
                                <div class="tab" style="display: block;">
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="name">Employee Code*</label>
                                            <input class="form-control" id="name" type="text" value="{{Auth::user()->employee_code}}" required="required" readonly name="use_id">
                                            <input class="form-control" id="name" type="hidden" value="{{Auth::user()->id}}" required="required" readonly name="use_id">
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label for="name">Employee Name*</label>
                                            <input class="form-control" id="name" type="text" value="{{Auth::user()->name}} {{Auth::user()->last_name}}" required="required" readonly>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="name">Leave Type*</label>
                                            <select class="form-select form-control {{ $errors->has('leave_type_id') ? ' has-error' : ''}}" name="leave_type_id">
                                                <option value=''>Select</option>
                                                @foreach ($leave_type as $lt)
                                                @if($lt->name == 'CL')
                                                <option value="{{$lt->id}}">Casual Leave</option>
                                                @elseif($lt->name == 'PL')
                                                <option value="{{$lt->id}}">Privilege Leave</option>
                                                @elseif($lt->name == 'SL')
                                                <option value="{{$lt->id}}">Sick Leave</option>
                                                @elseif($lt->name == 'LOP')
                                                @if($lop_visible["CL"] <= 0 && $lop_visible["PL"] <= 0 && $lop_visible["SL"] <= 0)
                                                <option value="{{$lt->id}}">LOP</option>
                                                @endif
                                                @endif
                                                @endforeach
                                            </select>
                                            @if ($errors->has('leave_type_id'))
                                            <div class="text-danger">{{ $errors->first('leave_type_id') }}</div>
                                            @endif
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <div class="col" id="radio-group">
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
                                                @if ($errors->has('fullDay'))
                                                <div class="text-danger">{{ $errors->first('fullDay') }}</div>
                                                @endif
                                            </div>


                                        </div>

                                        <div class="row ">
                                            <div class="mb-3 col-md-6 ">
                                                <label for="startDate">From Date*</label>
                                                <input class="form-control datepicker-here digits {{ $errors->has('startDate') ? ' has-error' : ''}} leave_picker " readonly id="startDate" data-position="bottom right" type="text" data-language="en" name="startDate" value="{{Carbon\Carbon::now()->format('d-m-Y')}}" placeholder="DD-MM-YYYY">
                                                @if ($errors->has('startDate'))
                                                <div class="text-danger">{{ $errors->first('startDate') }}</div>
                                                @endif
                                            </div>

                                            <div class="mb-3 col-md-6 showCta ">
                                                <label for="toDate">To Date*</label>
                                                <input class=" form-control datepicker-here digits {{ $errors->has('endDate') ? ' has-error' : ''}} leave_picker " readonly id="toDate" data-position="bottom right" type="text" data-language="en" name="endDate" value="{{Carbon\Carbon::now()->format('d-m-Y')}}" placeholder="DD-MM-YYYY">
                                                @if ($errors->has('endDate'))
                                                <div class="text-danger">{{ $errors->first('endDate') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="mb-3 col-md-12">
                                            <label for="name">Leave Reason*</label>
                                            <input class="form-control {{ $errors->has('leaveReason') ? ' has-error' : ''}}" id="name" name="leaveReason" type="text">
                                            @if ($errors->has('leaveReason'))
                                            <div class="text-danger">{{ $errors->first('leaveReason') }}</div>
                                            @endif
                                        </div>

                                    </div>
                                    <div>
                                        <div class="mt-4">
                                            <div class="text-right"><button class="btn btn-primary me-3" type="submit" id="loader"> Save </button>
                                                <a onclick="resetForm()" class="btn btn-danger me-3">Reset</a> <a href="{{route('leave.index')}}" class="btn btn-secondary me-3">Cancel</a>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- Container-fluid Ends-->
                                </div>
                            </form>
                            @else
                            <h2>You Are On Maternity Leave</h2>
                            @endif
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
                        <div class="row">
                            @foreach ($entitlements as $entitlement)
                            @if($entitlement != null && $entitlement->leaveType != 'LOP')
                            <div class="col text-center">
                                @if($entitlement->leaveType=="CL")
                                <h6 class="font-roboto">Casual Leave</h6>
                                @elseif($entitlement->leaveType=='PL')
                                <h6 class="font-roboto">Privilege Leave</h6>
                                @elseif($entitlement->leaveType=='SL')
                                <h6 class="font-roboto">Sick Leave</h6>
                                @endif
                                <h5 class="counter mb-0 font-roboto font-primary mt-1">{{$entitlement->balance}}</h5>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="preloader" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border: none; background: transparent;">
            <div class="modal-body">
                <div class="form-group">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col">
                                <div class="m-t-15 m-checkbox-inline">
                                    <p style="text-align: center;">
                                        <svg version="1.1" style="width: 100px; height: 100px;" id="L6" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
                                            <rect fill="none" stroke="#fff" stroke-width="4" x="25" y="25" width="50" height="50">
                                                <animateTransform attributeName="transform" dur="0.5s" from="0 50 50" to="180 50 50" type="rotate" id="strokeBox" attributeType="XML" begin="rectBox.end"></animateTransform>
                                            </rect>
                                            <rect x="27" y="27" fill="#fff" width="46" height="50">
                                                <animate attributeName="height" dur="1.3s" attributeType="XML" from="50" to="0" id="rectBox" fill="freeze" begin="0s;strokeBox.end"></animate>
                                            </rect>
                                        </svg>

                                        <!--<svg version="1.1" id="L7" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
                                            <path fill="#fff" d="M31.6,3.5C5.9,13.6-6.6,42.7,3.5,68.4c10.1,25.7,39.2,38.3,64.9,28.1l-3.1-7.9c-21.3,8.4-45.4-2-53.8-23.3
                                      c-8.4-21.3,2-45.4,23.3-53.8L31.6,3.5z">
                                                <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="2s" from="0 50 50" to="360 50 50" repeatCount="indefinite"></animateTransform>
                                            </path>
                                            <path fill="#fff" d="M42.3,39.6c5.7-4.3,13.9-3.1,18.1,2.7c4.3,5.7,3.1,13.9-2.7,18.1l4.1,5.5c8.8-6.5,10.6-19,4.1-27.7
                                     c-6.5-8.8-19-10.6-27.7-4.1L42.3,39.6z">
                                                <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="1s" from="0 50 50" to="-360 50 50" repeatCount="indefinite"></animateTransform>
                                            </path>
                                            <path fill="#fff" d="M82,35.7C74.1,18,53.4,10.1,35.7,18S10.1,46.6,18,64.3l7.6-3.4c-6-13.5,0-29.3,13.5-35.3s29.3,0,35.3,13.5
                                     L82,35.7z">
                                                <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="2s" from="0 50 50" to="360 50 50" repeatCount="indefinite"></animateTransform>
                                            </path>
                                        </svg>-->
                                    </p>
                                </div>
                            </div>
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
            $('#sd').text('Date*');
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
<script>
    function resetForm() {
        document.getElementById("leave").reset();
    }
</script>
<script>
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
<script>
    $("#loader").click(function(e) {
        $('#preloader').modal('show');
    });
</script>
@endsection