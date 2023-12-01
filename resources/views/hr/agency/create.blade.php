@extends('layouts.app')
@section('page_title')
<title>Add Consultancy</title>
@endsection
@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">

            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-sm-8 box-col-12">
                <div class="card">
                    <div class="card-body b-l-primary">
                        <div class="media"><i data-feather="file-plus"></i>
                            <div class="media-body px-3">
                                <h3 class="f-w-600 fs-4">Create Consultancy</h3>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-body">
                        @if(Session::has('message'))
                        <div class="alert alert alert-success" role="alert">
                            {{session::get('message')}}
                        </div>
                        @endif
                        @if(Session::has('error2'))
                        <div class="alert alert alert-danger" role="alert">
                            {{session::get('error2')}}
                        </div>
                        @endif
                        <div class="form theme-form projectcreate">
                            <form action="{{url('agency')}}" method="POST" id='consult' autocomplete="off">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="col-form-label">Consultancy Name*</label>
                                            <input type="text" name="consultancy_name" value="{{old('consultancy_name')}}" class=" form-control input-lg {{ $errors->has('consultancy_name') ? ' has-error' : ''}}" placeholder="Consultancy Name" />
                                            @if ($errors->has('consultancy_name'))
                                            <div class="text-danger">{{ $errors->first('consultancy_name') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="col-form-label">Contact Person*</label>
                                            <input type="text" name="contact_person" value="{{old('contact_person')}}" class=" form-control input-lg {{ $errors->has('contact_person') ? ' has-error' : ''}}" placeholder="Contact Person" />
                                            @if ($errors->has('contact_person'))
                                            <div class="text-danger">{{ $errors->first('contact_person') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Contact Number*</label>
                                            <input class=" form-control {{ $errors->has('contact_number') ? ' has-error' : ''}}" type="number" value="{{old('contact_number')}}" name="contact_number">
                                            @if ($errors->has('contact_number'))
                                            <div class="text-danger">{{ $errors->first('contact_number') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Email Id*</label>
                                            <input class=" form-control {{ $errors->has('email') ? ' has-error' : ''}}" type="email" value="{{old('email')}}" name="email">
                                            @if ($errors->has('email'))
                                            <div class="text-danger">{{ $errors->first('email') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Start Date*</label>
                                            <input class=" datepicker-here form-control {{ $errors->has('start_date') ? ' has-error' : ''}}" readonly type="text" data-position="top right" placeholder="DD-MM-YYYY" value="{{old('start_date')}}" name="start_date">
                                            @if ($errors->has('start_date'))
                                            <div class="text-danger">{{ $errors->first('start_date') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Alternate Email Id</label>
                                            <input class=" form-control {{ $errors->has('alternate_email') ? ' has-error' : ''}}" type="email" value="{{old('alternate_email')}}" name="alternate_email">
                                            @if ($errors->has('alternate_email'))
                                            <div class="text-danger">{{ $errors->first('alternate_email') }}</div>
                                            @endif
                                        </div>
                                    </div>


                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>End Date</label>
                                            <input class=" datepicker-here form-control {{ $errors->has('end_date') ? ' has-error' : ''}}" readonly type="text" data-position="top right" placeholder="DD-MM-YYYY" value="{{old('end_date')}}" name="end_date">
                                            @if ($errors->has('end_date'))
                                            <div class="text-danger">{{ $errors->first('end_date') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Status*</label>
                                            <select class="form-select {{ $errors->has('status') ? ' has-error' : ''}}" name="status">
                                                <option value="">Select</option>
                                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>InActive</option>

                                            </select>
                                            @if ($errors->has('status'))
                                            <div class="text-danger">{{ $errors->first('status') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col">
                                        <div class="text-end"> <button class="btn btn-primary me-3" type="submit"> Add </button> <a onclick="resetForm()" class="btn btn-danger me-3">Reset</a> <a href="{{route('agency.index')}}" class="btn btn-secondary me-3">Cancel</a></div>
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

@section('script')

<script>
    function resetForm() {
        document.getElementById("consult").reset();
    }
</script>
@endsection