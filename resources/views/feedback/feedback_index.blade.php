@extends('layouts.report')
 @section('page_title')
 <title>Feedback</title>
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

 <div class="page-body">
   <div class="container-fluid">
     <div class="page-title">
       <div class="row">
         <div class="col-12 col-sm-6">
           <h3>Feedback</h3>
         </div>
         <div class="col-12 col-sm-6">
         <span class="pull-right"><a href="{{url('feedback/create')}}" class="btn btn-primary " style="float: right;">Submit Feedback</a></span>
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
                     <th>Email ID</th>
                     <th>Type</th>                     
                     <th>Regarding</th>
                     <th>Description</th>
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
       "ajax": "{{ route('api.feedback.index') }}",
       columnDefs: [
                {
                    render: function (data, type, full, meta) {
                        return "<div class='text-wrap width-200'>" + data + "</div>";
                    },
                    targets: 5
                }
             ],  
       
       "columns": [
         {
          data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false 
         }, 
         {
           "data": "feedback_date",
           "render": function(data, type) {
                                return type === 'sort' ? data : moment(data).format('DD-MM-Y');
                                }
         },
         {
           "data": "email"
         },
         {
           "data": "hereismy"
         },
         {
           "data": "regarding"
         },
         {
           "data": "description"
         },
          
         {
           "data": "action",
         },

       ]
     });
   });
 </script>
 @endsection