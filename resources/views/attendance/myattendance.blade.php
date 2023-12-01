@extends('layouts.report')
 @section('page_title')
 <title>Attendance</title>
 @endsection
 @section('content')

 <div class="page-body">
   <div class="container-fluid">
     <div class="page-title">
       <div class="row">
         <div class="col-12 col-sm-6">
           <h3>My Attendance</h3>
         </div>
         <div class="col-12 col-sm-6">
         <span class="pull-right"><a href="{{url('attendance/create')}}" class="btn btn-primary " style="float: right;">Submit Attendance</a></span>
         </div>
       </div>
     </div>
   </div>
   <div class="container-fluid">
     <div class="row justify-content-center">
       <div class="col-md-12">
         <div class="card">         
           <div class="card-body">
             @if(Session::has('message'))
             <div class="alert alert alert-success" role="alert">
               {{session::get('message')}}
             </div>
             @endif
             <div class="table-responsive">
               <table class="display basic-1 " id="datatable">
                 <thead>
                   <tr>
                     <th>S.No.</th>
                     <th>Date</th>
                     <th>Employee ID</th>
                     <th>Employee Name</th>
                     <th>Primary Project</th>
                     <th>PP W Hrs</th>
                     <th>Secondary Project</th>
                     <th>SP W Hrs</th>
                     <th>TOT W Hrs</th>
                     <th>Action</th>

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
 @endsection

 @section('script')

 <script>
   $(document).ready(function() {
     $('#datatable').DataTable({
       "processing": true,
       "serverSide": true,
       "ajax": "{{ route('api.myattendances.index') }}",
       order:[1,'DESC'],
       "columns": [
         {
          data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false 
         }, 
         {
           "data": "attendance_date",
           "render": function(data, type) {
                                return type === 'sort' ? data : moment(data).format('DD-MM-Y');
                                }
         },
         {
           "data": "employee_code"
         },
         {
           "data": "employee_name"
         },
         {
           "data": "primary_project.0"
         },
         {
           "data": "primary_project_hours",orderable: false, searchable: false 
         },
         {
           "data": "secondary_project",orderable: false, searchable: false 
         },
         {
           "data": "secondary_project_hours",orderable: false, searchable: false 
         },
         {
           "data": "total_working_hours"
         },

         {
           "data": "action",
         },

       ]
     });
   });
 </script>
 @endsection