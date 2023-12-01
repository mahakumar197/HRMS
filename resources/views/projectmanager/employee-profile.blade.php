@extends('layouts.app')
@section('page_title')
<title>Employee Profile</title>
@endsection

@section('content')
<div class="page-body">
  <div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-sm-6">
          <h3>Employee Profile</h3>
        </div>
        @if(Auth::user()->role == 'super_admin' || Auth::user()->sub_role == 'hr')
        <div class="col-12 col-sm-6">
          <span class="pull-right"><a href="{{url('employee/'.$employee->id.'/edit')}}" class="btn btn-primary" style="float: right;">Edit Employee</a></span>
        </div>
        @endif
      </div>
    </div>
  </div>
  <!-- Container-fluid starts-->
  <div class="container-fluid">
    <div class="edit-profile">
      <div class="row">
        <div class="col-xl-4">
          <div class="card">
            <div class="card-body b-info">
              <div class="row mb-2">
                <div class="profile-title">
                  <div class="d-flex flex-column align-items-center text-center"> <img src="{{ URL::to('/') }}/image/{{ $employee->image_path}}" alt="Admin" class="rounded-circle" width="130">
                    <div class="mt-3 mb-2">
                      <h4>{{$employee->name}}  {{$employee->last_name}} </h4>
                      <p class="text-secondary mb-1">{{$employee->designation->designation}}</p>
                      <p class="text-muted font-size-sm">Employee Code : {{$employee->employee_code}} </p>
                    </div>
                  </div>               
                </div>
              </div>
              <h4 class="card-title text-secondary mb-4">BASIC INFO</h4>
              <div class="row mb-3">
                <div class="col-sm-5">
                  <h5 class="mb-0">Role : </h5>
                </div>
                <div class="col-sm-7 text-secondary">@if($employee->role == 'employee')
                  {{'Employee'}}@elseif($employee->role == 'project_manager'){{'Project Manager'}}
                  @elseif($employee->role == 'super_admin'){{'Super Admin'}}
                  @endif
                </div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-5">
                  <h5 class="mb-0">Date of Birth : </h5>
                </div>
                <div class="col-sm-7 text-secondary">{{Carbon\Carbon::parse($employee->birth_date)->format('d-m-Y')}}</div>
              </div>

              <div class="row mb-3">
                <div class="col-sm-5">
                  <h5 class="mb-0">Contact Number :</h5>
                </div>
                <div class="col-sm-7 text-secondary">{{$employee->phone_number}}</div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-5">
                  <h5 class="mb-0">Emergency Contact :</h5>
                </div>
                <div class="col-sm-7 text-secondary">{{$employee->emergency_contact}}</div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-5">
                  <h5 class="mb-0">Email :</h5>
                </div>
                <div class="col-sm-7 text-secondary">{{$employee->email}}</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xl-8">
          <div class="card">
            <div class="card-body b-l-info b-r-info">
              <h4 class="card-title text-primary mb-4">PERSONAL INFO</h4>
              <div class="row">
                <div class="col-md-6">
                  <div class="row mb-3">
                    <div class="col-sm-5">
                      <h5 class="mb-0">Name :</h5>
                    </div>
                    <div class="col-sm-7 text-secondary">{{$employee->name}} {{$employee->middle_name}} {{$employee->last_name}}</div>
                  </div>                  
                  <div class="row mb-3">
                    <div class="col-sm-5">
                      <h5 class="mb-0">{{$employee->dependency}} Name :</h5>
                    </div>
                    <div class="col-sm-7 text-secondary">{{$employee->dependency_name}}</div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-sm-5">
                      <h5 class="mb-0">Marital Status : </h5>
                    </div>
                    <div class="col-sm-7 text-secondary">{{$employee->marital_status}}</div>
                  </div>
                  @if(Auth::user()->role == 'super_admin')
                  <div class="row mb-3">
                    <div class="col-sm-5">
                      <h5 class="mb-0">PAN No : </h5>
                    </div>
                    <div class="col-sm-7 text-secondary">{{$employee->pan_number}}</div>
                  </div>
                  @endif
                </div>
                <div class="col-md-6">                  
                  <div class="row mb-3">
                    <div class="col-sm-5">
                      <h5 class="mb-0">Dependency :</h5>
                    </div>
                    <div class="col-sm-7 text-secondary">{{$employee->dependency}}</div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-5">
                      <h5 class="mb-0">Gender : </h5>
                    </div>
                    <div class="col-sm-7 text-secondary">{{$employee->gender}}</div>
                  </div>
                  @if(Auth::user()->role == 'super_admin')
                  <div class="row mb-3">
                    <div class="col-sm-5">
                      <h5 class="mb-0">Aadhar No : </h5>
                    </div>
                    <div class="col-sm-7 text-secondary">{{$employee->aadhar_number}}</div>
                  </div>
                  @endif

                </div>
                <div class="col-md-6">



                </div>
              </div>
              <div class="row">
                <div class="col-md-6">

                  <div class="row mb-3">
                    <div class="col-sm-5">
                      <h5 class="mb-0">Residential Address : </h5>
                    </div>
                    <div class="col-sm-7 text-secondary">{{$employee->res_address}}, {{$employee->res_city}}, {{$employee->res_state}}, {{$employee->res_postal_code}}, {{$employee->nationality}}. </div>
                  </div>
                </div>
                <div class="col-md-6">

                  <div class="row mb-3">
                    <div class="col-sm-5">
                      <h5 class="mb-0">Permanent Address : </h5>
                    </div>
                    <div class="col-sm-7 text-secondary">{{$employee->per_address}}, {{$employee->per_city}}, {{$employee->per_state}}, {{$employee->_postal_code}}, {{$employee->nationality}}. </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card">
            <div class="card-body b-l-info b-r-info">
              <h4 class="card-title text-primary mb-4">PROFESSIONAL INFO</h4>
              <div class="row">
                <div class="col-md-6">
                  <div class="row mb-3">
                    <div class="col-sm-5">
                      <h5 class="mb-0">Reporting To :</h5>
                    </div>
                    <div class="col-sm-7 text-secondary">@if($current_primary_project_id != null){{ $reporting_to->userteam->name }} {{ $reporting_to->userteam->last_name }} @else {{ $reporting_to }} @endif</div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-5">
                      <h5 class="mb-0">Joining Date :</h5>
                    </div>
                    <div class="col-sm-7 text-secondary">{{Carbon\Carbon::parse($employee->joining_date)->format('d-m-Y')}}</div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-5">
                      <h5 class="mb-0">Employee Status : </h5>
                    </div>
                    <div class="col-sm-7 text-secondary">
                      @if($employee->employee_status == '1')
                      {{'Active'}}
                      @else
                      {{'InActive'}}
                      @endif
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-5">
                      <h5 class="mb-0">Qualification : </h5>
                    </div>
                    <div class="col-sm-7 text-secondary">{{$employee->higest_qualification}}</div>
                  </div>

                </div>

                <div class="col-md-6">
                  <div class="row mb-3">
                    <div class="col-sm-5">
                      <h5 class="mb-0">Skill Set :</h5>
                    </div>
                    <div class="col-sm-7 text-secondary">{{$employee->skill_set}}</div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-5">
                      <h5 class="mb-0">Current Project : </h5>
                    </div>
                    <div class="col-sm-7 text-secondary">
                      @foreach($current_project as $project)
                      {{$project->project->project_name}}

                      @if( !$loop->last)
                      ,
                      @endif
                      @endforeach
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>


        <!-- Container-fluid Ends-->
      </div>
    </div>
  </div>
</div>
</div>
@endsection