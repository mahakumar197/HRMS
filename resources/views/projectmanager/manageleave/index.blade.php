@extends('layouts.report')
@section('page_title')
<title>Manage Leave</title>
@endsection
@section('style')
<style>.text-wrap{
    white-space:normal;
}
.width-200{
    width:200px;
}</style>
@endsection
@section('content')

<div id="mail_send"></div>
<div class="page-body">
  <div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-sm-6">
          <h3>Leave Approval</h3>
        </div>
        <div class="col-12 col-sm-6">
          <span class="pull-right"><a href="{{route ('assignleave.create') }}" class="btn btn-primary" style="float: right;">Assign Leave</a></span>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            @if($errors->any())
            @foreach ($errors->all() as $error)
            <div class="alert alert-danger dark alert-dismissible fade show" role="alert">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-down">
                <path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path>
              </svg>
              <p> {{$error}}</p>
              <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
            </div>
            @endforeach
            @endif


          </div>
          <div class="card-body">
            @if(Session::has('message'))
            <div class="alert alert alert-success" role="alert">
              {{session::get('message')}}
            </div>
            @endif
            @if(Session::has('message2'))
            <div class="alert alert alert-danger" role="alert">
              {{session::get('message2')}}
            </div>
            @endif
            <div class="table-responsive">
              <table class="display basic-1 app " id="datatable">
                <thead>
                  <tr>
                    <th>S.No.</th>
                    <th>Name</th>
                    <th>Leave Type</th>
                    <th>From Date</th>
                    <th>To Date</th>
                    <th>No of Days</th>
                    <th>Status</th>
                    <th>Remarks</th>
                    <th>Edit Leave</th>
                    <th>Action</th>                    
                    <th>Cancel Leave</th>
                    
                  </tr>
                </thead>
                <tbody>
                </tbody>
             
              </table>
            </div>

          </div>

        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Remarks</h5>
      </div>
      <div class="modal-body">
        <form action="{{url('approve')}}" method='POST' id="edit_form" autocomplete="off">
          @csrf
          <div class="form-group">
            <label for="message-text" class="col-form-label" id="title"></label>
            <textarea class="form-control" id="message-text" name="remarks"></textarea>
            <input type="hidden" class="l_id" name="id">
          </div>
      </div>
      <div class="modal-footer">
          
        <button type="submit" class="btn btn-primary" id="btn_submit">Submit</button>


      </div>


      </form>
    </div>
  </div>
</div>



@endsection

@section('script')


<script>
  var role = '{{Auth::user()->role}}';
  //console.log(role);
  $(document).ready(function() {
    var showAdminColumns =  role == "super_admin" ? true:false;
   
  var table =  $('#datatable').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": "{{ route('api.manageleaves.index') }}",
      "bDestroy": true,    
      columnDefs: [
                {
                    render: function (data, type, full, meta) {
                        return "<div class='text-wrap width-200'>" + data + "</div>";
                    },
                    targets: 7
                }
             ],  
      "columns": [
        {
          data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false 
        },
      
        {
          "data": "employee_name"
        },
        {
          "data": "leave_type"
        },
        {
          "data": "startDate",
          "render": function(data, type) {
                                return type === 'sort' ? data : moment(data).format('DD-MM-Y');
                                }
        },
        {
          "data": "endDate",
          "render": function(data, type) {
                                return type === 'sort' ? data : moment(data).format('DD-MM-Y');
                                }
        },
        {
          "data": "noOfDayDeduct"
        },
        {
          "data": "leaveStatus"
        },
        {
          "data": "remarks"
        },
        {
          "data": "editLeave",visible : showAdminColumns
        },
        {
          "data": "action",
        },
        {
          "data": "cancelLeave",
        },
        


      ]
    });
 
  });


 
</script>
<script>
  let $modal = $('#exampleModal');

  function testFunction(event, id) {
    event.preventDefault();

    $('#title').html('Reason For Leave Approve');
    $('#userid').attr(id);
    $modal.modal('show');
    $('.l_id').val(id);

  }

  function testFunction_reject(event, id) {
    event.preventDefault();
    $("#edit_form").attr('action', "{{url('reject')}}");
    $('#userid').attr(id);
    $('#title').html('Reason For Leave Reject');
    $modal.modal('show');
    $('.l_id').val(id);

  }
  function testFunction_cancel(event, id) {
    event.preventDefault();
    $("#edit_form").attr('action', "{{url('approvedcancel')}}");
    $('#userid').attr(id);
    $('#title').html('Reason For Leave Cancel');
    $modal.modal('show');
    $('.l_id').val(id);

  }

  
</script>

<script>

$("#btn_submit").click(function(){

  $('#mail_send').append('<div class="loader-wrapper" style="opacity: 0.980147;"><div class="loader"><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-ball"></div></div></div>');
  //alert("The paragraph was clicked.");
});
</script>



@endsection