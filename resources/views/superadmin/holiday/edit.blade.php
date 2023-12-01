@extends('layouts.app')
@section('page_title')
<title>Edit Holiday</title>
@endsection
@section('style')
<style>
  select[readonly]  {
    pointer-events: none;
}
</style>
@endsection
@section('content')

<div class="page-body">
  <div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-sm-6">
          <h3>
            Edit Holiday</h3>
        </div>
        <div class="col-12 col-sm-6">

        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid">



    <div class="row">
      <div class="col-sm-8">
        <div class="card">
          <div class="card-body">
       


            @if(Session::has('message'))
            <div class="alert alert alert-success" role="alert">
              {{session::get('message')}}

            </div>
            @endif


            <div class="form theme-form projectcreate">
              <form action="{{url ('holiday/'.$holiday->id) }}" method="POST" autocomplete="off">
                @csrf
                @method('PUT')
                <div class="row">
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Holiday Name</label>
                      <input class="form-control {{ $errors->has('holidayname') ? ' has-error' : ''}}" type="text" placeholder="Holiday Name *" name="holidayname" value="{{$holiday->holidayname }}">
                      @if ($errors->has('holidayname'))
                      <div class="text-danger">{{ $errors->first('holidayname') }}</div>
                      @endif
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Holiday Date</label>
                      <input class="datepicker-here form-control digits {{ $errors->has('holidaydate') ? ' has-error' : ''}}" data-date-format="dd-mm-yyyy" placeholder="DD-MM-YYYY" data-language="en" data-position="bottom right" type="text"  name="holidaydate" value="{{Carbon\Carbon::parse($holiday->holidaydate)->format('d-m-Y')}}">
                      @if ($errors->has('holidaydate'))
                      <div class="text-danger">{{ $errors->first('holidaydate') }}</div>
                      @endif
                    </div>
                  </div>

                </div>
                <div class="row">
                  <div class="col-sm-4">
                    <div class="mb-3">
                      <label>Holiday Type</label>
                      <select class="form-select {{ $errors->has('holidaytype') ? ' has-error' : ''}}" name="holidaytype" placeholder="select" value="{{$holiday->holidaytype  }}" readonly >
                        <option value="">Select</option>
                        <option value="External" {{$holiday->holidaytype == 'External' ?'selected':''}}>External</option>
                        <option value="Internal" {{$holiday->holidaytype == 'Internal' ?'selected':''}}>Internal</option>
                      </select>
                      @if ($errors->has('holidaytype'))
                      <div class="text-danger">{{ $errors->first('holidaytype') }}</div>
                      @endif
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="mb-3">
                      <label>Holiday Scope</label>
                      <select class="form-select {{ $errors->has('holidayscope') ? ' has-error' : ''}}" name="holidayscope" value="{{$holiday->holidayscope  }}" readonly>
                        <option value="">Select</option>
                        <option value="Bank Holiday" {{$holiday->holidayscope == 'Bank Holiday' ?'selected':''}}>Bank Holiday</option>
                        <option value="Sword Holiday" {{$holiday->holidayscope == 'Sword Holiday' ?'selected':''}}>Sword Holiday</option>
                      </select>
                      @if ($errors->has('holidayscope'))
                      <div class="text-danger">{{ $errors->first('holidayscope') }}</div>
                      @endif
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="mb-3">
                      <label>Holiday Status</label>
                      <select class="form-select {{ $errors->has('holidaystatus') ? ' has-error' : ''}}" name="holidaystatus" value="{{$holiday->holidaystatus  }}" readonly >
                        <option value="">Select</option>

                        <option value="1" {{$holiday->holidaystatus == '1' ?'selected':''}}>Active</option>
                        <option value="0" {{$holiday->holidaystatus == '0' ?'selected':''}}>InActive</option>
                      </select>
                      @if ($errors->has('holidaystatus'))
                      <div class="text-danger">{{ $errors->first('holidaystatus') }}</div>
                      @endif
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col">
                    <div class="text-center"><input type="submit" class="btn btn-primary me-3" value="Update"> <a href="{{route('holiday.index')}}" class="btn btn-secondary me-3">Cancel</a></div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')

<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<script>
  tinymce.init({
    selector: 'textarea#editor',
    menubar: false
  });
</script>

@endsection