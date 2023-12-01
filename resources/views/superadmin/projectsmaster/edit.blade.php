@extends('layouts.app')

@section('page_title')
<title>Edit Project</title>
@endsection

@section('content')

<!-- Page Sidebar Ends-->
<div class="page-body">
  <div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-sm-6">
          <h3>
            Edit Project</h3>
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
              <form action="{{url ('projects/'.$projectmaster->id) }}" method="POST" autocomplete="off">
                @csrf
                @method('PUT')
                <div class="row">
                  <div class="col-6">
                    <div class="mb-3">
                      <label>Project Id*</label>
                      <input class="form-control {{ $errors->has('project_id') ? ' has-error' : ''}}" type="text" placeholder="Project Id" disabled name="project_id" value="{{$projectmaster->project_id }}">
                      @if ($errors->has('project_id'))
                      <div class="text-danger">{{ $errors->first('project_id') }}</div>
                      @endif
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="mb-3">
                      <label>Project Title*</label>
                      <input class="form-control {{ $errors->has('project_name') ? ' has-error' : ''}}" type="text" placeholder="Project Title" disabled name="project_name" value="{{$projectmaster->project_name}}">
                      @if ($errors->has('project_name'))
                      <div class="text-danger">{{ $errors->first('project_name') }}</div>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">

                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Project Manager*</label>
                      <select class="form-select {{ $errors->has('project_manager') ? ' has-error' : ''}}" name="project_manager">
                        <option value="">select</option>
                        @foreach ($user as $d)
                        <option value="{{$d->id}}" {{$d->id == $projectmaster->user_id ?'selected':''}}>{{ $d->name}} {{$d->last_name}}</option>
                        @endforeach
                      </select>
                      @if ($errors->has('project_manager'))
                      <div class="text-danger">{{ $errors->first('project_manager') }}</div>
                      @endif
                    </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Location*</label>                      
                      <input class="form-control {{ $errors->has('project_location') ? ' has-error' : ''}}" type="text" placeholder="Location *"  name="project_location" value="{{$projectmaster->location}}" id="country">      
                      @if ($errors->has('project_location'))
                      <div class="text-danger">{{ $errors->first('project_location') }}</div>
                      @endif                
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Start Date*</label>
                      <input class="datepicker-here form-control digits {{ $errors->has('start_date') ? ' has-error' : ''}}" type="text" name="start_date" value="{{Carbon\Carbon::parse($projectmaster->start_date)->format('d-m-Y') }}">
                      @if ($errors->has('start_date'))
                      <div class="text-danger">{{ $errors->first('start_date') }}</div>
                      @endif
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>End Date*</label>
                      <input class="datepicker-here form-control digits {{ $errors->has('end_date') ? ' has-error' : ''}}" type="text" name="end_date" value="{{Carbon\Carbon::parse($projectmaster->end_date)->format('d-m-Y') }}">
                      @if ($errors->has('end_date'))
                      <div class="text-danger">{{ $errors->first('end_date') }}</div>
                      @endif
                    </div>
                  </div>

                </div>

                <div class="row">
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Billing Mode*</label>
                      <select class="form-select {{ $errors->has('billing_mode') ? ' has-error' : ''}}" name="billing_mode" >
                        <option value="">select</option>
                        <option value="daily" {{$projectmaster->billing_mode == 'daily' ? 'selected':'' }}>Daily</option>
                        <option value="hourly"{{$projectmaster->billing_mode == 'hourly' ? 'selected':'' }}>Hourly</option>
                      </select>     
                      @if ($errors->has('billing_mode'))
                      <div class="text-danger">{{ $errors->first('billing_mode') }}</div>
                      @endif                 
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Currency*</label>
                      <input class="form-control {{ $errors->has('currency') ? ' has-error' : ''}}" type="text" placeholder="currency" name="currency" value="{{$projectmaster->currency}}" id="currency">     
                      @if ($errors->has('currency'))
                      <div class="text-danger">{{ $errors->first('currency') }}</div>
                      @endif                
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col">
                    <div class="text-right"> <button class="btn btn-primary me-3" type="submit">Update </button><a href="{{route('projects.index')}}" class="btn btn-secondary me-3">Cancel</a></div>
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