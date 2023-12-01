
@extends('layouts.app')

@section('page_title')
<title>Edit Casual Leave Entitlement</title>
@endsection

@section('content')

<!-- Page Sidebar Ends-->
<div class="page-body">
  <div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-sm-6">
          <h3>
            Edit Casual Leave Entitlement</h3>
        </div>
        <div class="col-12 col-sm-6">

        </div>
      </div>
    </div>
  </div>
  <!-- Container-fluid starts-->
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">

            @if(Session::has('message'))
            <div class="alert alert-success dark alert-dismissible fade show" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up">
                <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
              </svg>
              <p> {{session::get('message')}}</p>
              <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
            </div>
            @endif

            @if(Session::has('error'))
            <div class="alert alert-danger dark alert-dismissible fade show" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-down">
                <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
              </svg>
              <p> {{session::get('error')}}</p>
              <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
            </div>
            @endif



            <div class="form theme-form projectcreate">
              <form action="{{url ('casualleave/'.$employee->id) }}" method="POST" autocomplete="off">
                @csrf
                @method('PUT')
                @method('PUT')
                <div class="row">
                  <div class="col-6">
                    <div class="mb-3">
                      <label>Employee Code*</label>
                      <input class="form-control {{ $errors->has('employee_code') ? ' has-error' : ''}}" type="text"  disabled name="employee_code" value="{{$employee->user->employee_code }}">
                      @if ($errors->has('employee_code'))
                      <div class="text-danger">{{ $errors->first('employee_code') }}</div>
                      @endif
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="mb-3">
                      <label>Project Title*</label>
                      <input class="form-control {{ $errors->has('employee_name') ? ' has-error' : ''}}" type="text"  disabled name="employee_name" value="{{$employee->user->name}}">
                      @if ($errors->has('employee_name'))
                      <div class="text-danger">{{ $errors->first('employee_name') }}</div>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">

                    <div class="col-6">
                        <div class="mb-3">
                          <label>Leave Type*</label>
                          <input class="form-control {{ $errors->has('leavetype') ? ' has-error' : ''}}" type="text"  disabled name="leavetypename" value="{{$employee->leaveType->name}}">
                          <input class="form-control " type="hidden"  disabled name="leavetype" value="{{$employee->leave_type_id}}">
                          @if ($errors->has('leavetype'))
                          <div class="text-danger">{{ $errors->first('leavetype') }}</div>
                          @endif
                        </div>
                      </div>



                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Entitlement*</label>
                      <input class="form-control {{ $errors->has('entitlement') ? ' has-error' : ''}}" type="text" placeholder="Entitlement"  name="entitlement" value="{{$employee->entitlement}}" id="country">
                      @if ($errors->has('entitlement'))
                      <div class="text-danger">{{ $errors->first('entitlement') }}</div>
                      @endif
                    </div>
                  </div>
                </div>




                <div class="row">
                  <div class="col">
                    <div class="text-right"> <button class="btn btn-primary me-3" type="submit">Update </button><a href="{{route('casualleave.index')}}" class="btn btn-secondary me-3">Cancel</a></div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Container-fluid Ends-->
</div>



@endsection
