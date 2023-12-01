@extends('layouts.app')

@section('page_title')
<title>Assign Attendance</title>
@endsection

@section('content')

<div class="page-body">
  <div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-sm-6">
          <h3>{{ __(' Assign Attendance') }}</h3>
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
            <form action=" " method="POST" autocomplete="off">
              @csrf
              <label for="selectstatus">Select Employee</label>
              <select class="form-select" name="user"  required id="selectstatus">
                <option value="">Select</option>
                @foreach($employee as $emp)
                <option value="{{$emp->id}}" status-id="{{$emp->id}}">{{$emp->name}} {{$emp->last_name}}</option>
                @endforeach
              </select>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
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

            @if(Session::has('message'))
            <div class="alert alert-success dark alert-dismissible fade show" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up">
                <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
              </svg>
              <p> {{session::get('message')}}</p>
              <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
            </div>
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

            <form action="{{url ('assignattendance') }}" method="POST" autocomplete="off">

              @csrf

              <div class='row  ' id="subcat">
              </div>

              <div class="mb-3 col-md-6">
                <label for="name">Date</label>
                <input class="datepicker-here form-control" readonly value="{{  Carbon\Carbon::now()->format('d-m-Y') }}"  id="attendance_picker" type="text" required="required" data-position="bottom right" placeholder="DD-MM-YYYY" name="attendance_date">
              </div>

              <div class="row">
                <div class="col">
                  <div class="text-right"> <button class="btn btn-primary me-3" type="submit"> Add </button></div>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>


</div>


@endsection

@section('script')

<script>
  $(document).ready(function() {

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    $("#selectstatus").change(function() {

      var project = $(this).val();
      var getid = $(this).attr("status-id");
      $.ajax({
        type: 'POST',
        url: "{{ route('assign_attendance_filter') }}",
        data: {
          project: project,

          getid: getid
        },
        success: function(data) {

          $('div[id="subcat"]').html(data);


        },
        error: function(Result) {

          $('div[id="subcat"]').html('No Primary Project ');
        }
      });
    });


  });
</script>


<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

<!-- Script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
  // CSRF Token
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  $(document).ready(function() {


    $("#employee_search").autocomplete({
      source: function(request, response) {

        // Fetch data
        $.ajax({

          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: "{{route('empfetchass')}}",
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
        $('#employee_search').val(ui.item.label + ' ' + ui.item.label2);
        $("#emp_id").attr("value", ui.item.value); // display the selected text        
        $(".emp_code").val(ui.item.label2);
        //$('#designation').val(ui.item.designation);



        // save selected id to input

        return false;
      }
    });


    ///search code

    $("#emp_code").autocomplete({
      source: function(request, response) {

        // Fetch data
        $.ajax({

          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: "{{route('empfetchassempcode')}}",
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
        $('#emp_code').val(ui.item.label2);
        $("#emp_id").attr("value", ui.item.value); // display the selected text        
        $(".emp_name").val(ui.item.label);
        //$('#designation').val(ui.item.designation);



        // save selected id to input

        return false;
      }
    });




  });
</script>

<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/themes/base/jquery-ui.css" type="text/css" media="all">



<script>
  $('#date').datepicker({
    changeMonth: true,
    changeYear: true,
    showButtonPanel: true,
    yearRange: "-100:+0",
    dateFormat: 'dd/mm/yy'

  });
</script>
@endsection