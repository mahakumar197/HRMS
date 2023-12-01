@extends('layouts.app')
@section('page_title')
<title>Add Holiday</title>
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
            Create Holiday</h3>
        </div>
        <div class="col-12 col-sm-6">
         
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-8">
        
      @if(Session::has('error'))
        <div class="alert alert alert-danger" role="alert">
          {{session::get('error')}}

        </div>
        @endif
        @if(Session::has('message'))
        <div class="alert alert alert-success" role="alert">
          {{session::get('message')}}

        </div>
        @endif
        <div class="card">
          <div class="card-body">
            <div class="form theme-form projectcreate">
              <form action="{{url ('holiday') }}" method="POST" id='holi' autocomplete="off">
                @csrf
                <div class="row">
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Holiday Name</label>
                      <input class="form-control {{ $errors->has('holidayname') ? ' has-error' : ''}}" type="text" placeholder="Holiday Name *" name="holidayname">
                      @if ($errors->has('holidayname'))
                      <div class="text-danger">{{ $errors->first('holidayname') }}</div>
                      @endif
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Holiday Date</label>
                      <input class="datepicker-here form-control digits {{ $errors->has('holidaydate') ? ' has-error' : ''}}"  data-date-format="dd-mm-yyyy" placeholder="DD-MM-YYYY" 
                      data-position="bottom right" type="text" data-language="en" name="holidaydate">
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
                      <select class="form-select {{ $errors->has('holidaytype') ? ' has-error' : ''}}"  name="holidaytype" placeholder="select" readonly >
                        <option value="">Select</option>
                        <option value="External" selected>External</option>
                        <option value="Internal">Internal</option>
                      </select>
                      @if ($errors->has('holidaytype'))
                      <div class="text-danger">{{ $errors->first('holidaytype') }}</div>
                      @endif
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="mb-3">
                      <label  value="">Holiday Scope</label>
                      <select class="form-select {{ $errors->has('holidayscope') ? ' has-error' : ''}}"   name="holidayscope" readonly>
                        <option value="">Select</option>
                        <option value="Bank Holiday" selected>Bank Holiday</option>
                        <option value="Sword Holiday">Sword Holiday</option>
                      </select>
                      @if ($errors->has('holidayscope'))
                      <div class="text-danger">{{ $errors->first('holidayscope') }}</div>
                      @endif
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="mb-3">
                      <label>Holiday Status</label>
                      <select class="form-select {{ $errors->has('holidaystatus') ? ' has-error' : ''}}"  name="holidaystatus" readonly>
                        <option value="">Select</option>
                        <option value="1" selected>Active</option>
                        <option value="0">InActive</option>
                      </select>
                      @if ($errors->has('holidaystatus'))
                      <div class="text-danger">{{ $errors->first('holidaystatus') }}</div>
                      @endif
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col">
                    <div class="text-center"><input type="submit" class="btn btn-primary me-3" value="Add"><a  onclick="resetForm()" class="btn btn-danger me-3">Reset</a><a href="{{route('holiday.index')}}" class="btn btn-secondary me-3">Cancel</a></div>
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
<script>
    function resetForm() {
      document.getElementById("holi").reset();
    }
  </script>
@endsection