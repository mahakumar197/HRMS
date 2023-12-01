@extends('layouts.app')

@section('page_title')
<title>Edit Leave</title>
@endsection

@section('content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>{{ __('Edit Leave') }}</h3>
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

                        <div class="form theme-form projectcreate">
                            <form action="{{url ('leave/'.$leave->id) }}" method="post" id='leave' autocomplete="off">
                                @csrf
                                @method('PUT')
                                <div class="tab" style="display: block;">
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="name">Employee Code*</label>
                                            <input class="form-control" id="name" type="text" value="{{$leave->user->employee_code}}" required="required" readonly name="use_id">
                                            <input class="form-control" id="name" type="hidden" value="{{$leave->user->id}}" required="required" readonly name="use_id">
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label for="name">Employee Name*</label>
                                            <input class="form-control" id="name" type="text" value="{{$leave->user->name}} {{$leave->user->last_name}}" required="required" readonly>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="mb-3 col-md-6">
                                            <label for="name">Leave Type*</label>
                                            <select class="form-select form-control {{ $errors->has('leave_type_id') ? ' has-error' : ''}}" name="leave_type_id">
                                                <option value=''>Select</option>
                                                @foreach ($leave_type as $lt)
                                                @if($lt->name == 'CL')
                                                <option value="{{$lt->id}}" {{$lt->id == $leave->leave_type_id ?'selected':''}}>Causal Leave</option>
                                                @elseif($lt->name == 'PL')
                                                <option value="{{$lt->id}}" {{$lt->id == $leave->leave_type_id ?'selected':''}}>Privilege Leave</option>
                                                @elseif($lt->name == 'SL')
                                                <option value="{{$lt->id}}" {{$lt->id == $leave->leave_type_id ?'selected':''}}>Sick Leave</option>
                                                @elseif($lt->name == 'LOP')
                                                <option value="{{$lt->id}}" {{$lt->id == $leave->leave_type_id ?'selected':''}}>LOP</option>
                                                @endif
                                                @endforeach
                                            </select>
                                            @if ($errors->has('leave_type_id'))
                                            <div class="text-danger">{{ $errors->first('leave_type_id') }}</div>
                                            @endif
                                        </div>

                                        <div class="mb-3 col-md-6">

                                            <div class="col">
                                                <div class="m-t-15 m-checkbox-inline custom-radio-ml">
                                                    <div class="form-check form-check-inline radio radio-primary halfday">
                                                        <input class="form-check-input" id="radioinline3" type="radio" name="fullDay" value="0" {{$leave->fullDay == '0' ?'checked':''}}>
                                                        <label class="form-check-label mb-0" for="radioinline3">Half Day </label>
                                                    </div>
                                                    <div class="form-check form-check-inline radio radio-primary">
                                                        <input class="form-check-input" id="radioinline1" type="radio" name="fullDay" value="1" {{$leave->fullDay == '1' ?'checked':''}}>
                                                        <label class="form-check-label mb-0" for="radioinline1">Single Day </label>
                                                    </div>
                                                    <div class="form-check form-check-inline radio radio-primary">
                                                        <input class="form-check-input" id="radioinline2" type="radio" name="fullDay" value="2" {{$leave->fullDay == '2' ?'checked':''}}>
                                                        <label class="form-check-label mb-0" for="radioinline2">Multi Day </label>
                                                    </div>

                                                </div>
                                                @if ($errors->has('fullDay'))
                                                <div class="text-danger">{{ $errors->first('fullDay') }}</div>
                                                @endif
                                            </div>

                                        </div>
                                        

                                        <div class="row">
                                            <div class="mb-3 col-md-6 ">
                                                <label for="startDate">From Date*</label>
                                                <input  class="datepicker-here form-control digits leave_picker  {{ $errors->has('startDate') ? ' has-error' : ''}}" readonly id="startDate" type="text" data-language="en" name="startDate"  placeholder="{{Carbon\Carbon::parse($leave->startDate)->format('d-m-Y')}}">
                                                @if ($errors->has('startDate'))
                                                <div class="text-danger">{{ $errors->first('startDate') }}</div>
                                                @endif
                                            </div>


                                            <div class="mb-3 col-md-6 showCta ">
                                                <label for="toDate">To Date*</label>
                                                <input class="datepicker-here form-control digits leave_picker {{ $errors->has('endDate') ? ' has-error' : ''}}" id="toDate" readonly type="text" data-language="en" name="endDate" placeholder="{{Carbon\Carbon::parse($leave->endDate)->format('d-m-Y')}}">
                                                @if ($errors->has('endDate'))
                                                <div class="text-danger">{{ $errors->first('endDate') }}</div>
                                                @endif
                                            </div>

                                        </div>
                                       

                                        <div class="mb-3 col-md-12">
                                            <label for="name">Leave Reason*</label>
                                            <input class="form-control {{ $errors->has('leaveReason') ? ' has-error' : ''}}" id="name" name="leaveReason" type="text" value="{{$leave->leaveReason}}">
                                            @if ($errors->has('leaveReason'))
                                            <div class="text-danger">{{ $errors->first('leaveReason') }}</div>
                                            @endif
                                        </div>

                                    </div>
                                    <div>

                                        <div class="mt-4">
                                            <div class="text-right"><button class="btn btn-primary me-3" type="submit"> Save </button> 
                                            @if(Auth::user()->role == 'super_admin' && $leave->user_id != Auth::id()) 
                                            <a onclick="resetForm()" class="btn btn-danger me-3">Reset</a> 
                                            <a href="{{route('manageleave.index')}}" class="btn btn-secondary me-3">Cancel</a>
                                            @else
                                            <a onclick="resetForm()" class="btn btn-danger me-3">Reset</a> 
                                            <a href="{{route('leave.index')}}" class="btn btn-secondary me-3">Cancel</a>

                                            @endif
                                        
                                        
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

    //Edit Date

    function showDiv() {
        document.getElementById('welcomeDiv').style.display = "block";
    }
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
@endsection