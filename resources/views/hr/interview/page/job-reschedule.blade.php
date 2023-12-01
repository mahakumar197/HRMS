 <div class="modal-header">
   <h4 class="modal-title">{{$reschedule_interview->jobdetails->job_code}} - {{$roundname}}</h4>
   <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" data-bs-original-title="" title=""></button>
 </div>
 <div class="modal-body">
   <div class="error_schedule mb-2"></div>
   <div class="success_schedule"></div>


   <div class="form theme-form projectcreate">
     <form action="#" method="POST" id="reschedule_interview" autocomplete="off">
       @csrf

       <div class="row">
         <div class="col-12">
           <div class="mb-3">
             <label>Position Name*</label>
             <input class="form-control " type="text" placeholder="Position Name" value="{{$reschedule_interview->jobdetails->position->position_name}}" disabled>
             <input class="form-control " type="hidden" placeholder="Position Name" id="job_id" name="job_id" value="{{$reschedule_interview->job_id}}">
             <input class="form-control " type="hidden" name="ji" id="ji" value="{{$reschedule_interview->jobinterview->id}}">
             <input class="form-control " type="hidden" name="round" value="{{$round}}">
             <input class="form-control " type="hidden" id="find_id" value="{{$reschedule_interview->id}}">
             <input class="form-control " type="hidden" name="round_id" value="{{$reschedule_interview->round_id}}">

           </div>
         </div>
       </div>
       <div class="row">
         <div class="col-6">
           <div class="mb-3">
             <label>Interviewer Name*</label>
             <input type="text" id='employee_search' class="typeahead form-control input-lg {{ $errors->has('interviewer_id') ? ' has-error' : ''}}" value="{{$reschedule_interview->employee->name}}" />
             <input type="hidden" name="interviewer_id" id='emp_id' value='{{$reschedule_interview->interviewer_id}}' class="form-control input-lg" />
           </div>
         </div>
         <div class="col-6">
           <div class="mb-3">
             <label>Second Interviewer Name</label>
             <input type="text" id='employee_2_search' class="typeahead form-control input-lg {{ $errors->has('interviewer_2_id') ? ' has-error' : ''}}" value="{{$reschedule_interview->interviewer_2_id != null ?$reschedule_interview->interviewer->name:""}}" />
             <input type="hidden" name="interviewer_2_id" id='emp_2_id' value='{{$reschedule_interview->interviewer_2_id != null ? $reschedule_interview->interviewer_2_id :'' }}' class="form-control input-lg" />
           </div>
         </div>

       </div>
       <div class="row">
         <div class="col-sm-6">
           <div class="mb-3">
             <label>Attendee Name*</label>
             <input class="form-control " type="text" placeholder="Attendee Name" id="attendee_name" value="{{$reschedule_interview->candetails->name}}" disabled>
             <input type="hidden" value='{{$reschedule_interview->can_id}}' name='can_id' id="can_id" class="form-control" />
           </div>
         </div>
         <div class="col-sm-6">
           <div class="mb-3">
             <label>Attendee Email Id*</label>
             <input class="form-control " type="email" placeholder="Attendee Email" name="attendee_email" value="{{$reschedule_interview->candetails->email}}" disabled>
           </div>
         </div>
       </div>
       <div class="row">
         <div class="col-sm-6">
           <div class="mb-3">
             <label>Interview Date*</label>
             <input class="datepicker-here form-control digits" type="text" data-language="en" name="schedule_date" placeholder="DD-MM-YYYY" value="{{Carbon::parse($reschedule_interview->schedule_date)->format('d-m-Y')}}">
           </div>
         </div>
         <div class="col-sm-6">
           <div class="mb-3">
             <label>Interview Time*</label>

             <!--<div class="input-group clockpicker pull-center" data-placement="left" data-align="top" data-autoclose="true">
                          <input class="form-control" type="text" name="schedule_time" value="{{$reschedule_interview->schedule_time}}"><span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                        </div>-->
             <div class="input-group date" id="dt-time" data-target-input="nearest">
               <input class="form-control datetimepicker-input digits" type="text" data-target="#dt-time" name="schedule_time" value="{{$reschedule_interview->schedule_time}}">
               <div class="input-group-text" data-target="#dt-time" data-toggle="datetimepicker"><i class="fa fa-clock-o"></i></div>
             </div>


           </div>
         </div>
       </div>
       <div class="row">
         <div class="col-sm-6">
           <div class="mb-3">
             <label>Interview Type*</label>
             <select class="form-select " name="interview_type">
               <option value="">Select</option>
               <option value="Telephonic Interview" {{$reschedule_interview->interview_type == 'Telephonic Interview' ?'selected':''}}>Telephonic Interview</option>
               <option value="Skype" {{$reschedule_interview->interview_type == 'Skype' ?'selected':''}}>Skype</option>
               <option value="Google Meet" {{$reschedule_interview->interview_type == 'Google Meet' ?'selected':''}}>Google Meet</option>
               <option value="Microsoft Teams" {{$reschedule_interview->interview_type == 'Microsoft Teams' ?'selected':''}}>Microsoft Teams</option>
               <option value="Face to Face" {{$reschedule_interview->interview_type == 'Face to Face' ?'selected':''}}>Face to Face</option>
             </select>
           </div>
         </div>
         <div class="col-sm-6">
           <div class="mb-3">
             <label>Meeting Link*</label>
             <input class="form-control " type="text" placeholder="Meeting Link" name="meeting_link" value="{{$reschedule_interview->meeting_link}}">
           </div>
         </div>
       </div>

       <div class="row">
         <div class="col">
           <div class="text-right"> <button class="btn btn-primary me-3" type="submit" id="reschedule_submit">ReSchedule </button>
             <a href="#" data-bs-dismiss="modal" aria-label="Close" class="btn btn-secondary me-3">Cancel</a>
           </div>
         </div>
       </div>
     </form>
   </div>
 </div>


 <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.js') }}"></script>
 <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.en.js') }}"></script>
 <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.custom.js') }}"></script>

 <script src="{{ asset('assets/js/datepicker/date-time-picker/moment.min.js') }}"></script>
 <script src="{{ asset('assets/js/datepicker/date-time-picker/tempusdominus-bootstrap-4.min.js') }}"></script>
 <script src="{{ asset('assets/js/datepicker/date-time-picker/datetimepicker.custom.js') }}"></script>

 <script src="{{ asset('assets/js/time-picker/jquery-clockpicker.min.js') }}"></script>
 <script src="{{ asset('assets/js/time-picker/highlight.min.js') }}"></script>
 <script src="{{ asset('assets/js/time-picker/clockpicker.js') }}"></script>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
 <style rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/smoothness/jquery-ui.min.css"></style>

 <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/timepicker.css') }}">
 <script>


 </script>
 <script>
   $('#reschedule_interview').on('submit', function(event) {
     event.preventDefault();

     var id = $('#find_id').val();

     var can_id = $('#can_id').val();

     var job_id = $('#job_id').val();

     var ji = $('#ji').val();


     var ajaxurl = '{{url("job-schedule","id")}}';
     ajaxurl = ajaxurl.replace('id', id);

     $.ajax({
       url: ajaxurl,
       method: 'PUT',
       data: $(this).serialize(),



       dataType: 'json',
       beforeSend: function() {
         $('#reschedule_submit').attr('disabled', 'disabled');
         $('#mail_send').append('<div class="loader-wrapper" style="opacity: 0.980147;"><div class="loader"><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-ball"></div></div></div>');
       },

       success: function(data) {

         var details = '<div class="alert alert-success dark alert-dismissible fade show" role="alert">' + data.success + ' <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button></div>'
         $('.success_schedule').html(details);
         $('#mail_send').empty();
         getcandetails(ji, job_id);
         $('#schedule_modal').modal('hide');
       },

       error: function(data) {
         $('#mail_send').empty();
         let error = data["responseJSON"]["errors"];
         let error2 = data["responseJSON"]["message"];
         var error_html = '';
         $.each(error, function(code, message) {
           error_html += '<p>' + message + '</p>';
         });
         $('.error_schedule').html('<div class="alert alert-danger dark alert-dismissible fade show" role="alert">' + error_html + '<button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button></div>');
         $(":submit").removeAttr("disabled");

       }
     })

   });
 </script>

 <script>
   function getMoreUsersagian(can_id, job_id) {

     $.ajax({
       type: "GET",
       data: {
         'id': can_id,
         'job': job_id
       },
       url: "{{ route('get-can-details') }}",
       success: function(data) {

         $('#candetails').html(data);

         $(".customizer-contain").addClass("open");
         $(".customizer-links").addClass("open");

       }
     });
   }
 </script>

 <script>
   // CSRF Token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

   $("#employee_search").autocomplete({
     source: function(request, response) {

       // Fetch data
       $.ajax({

         headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         url: "{{route('datafetch')}}",
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
       $('#employee_search').val(ui.item.label2 + '-' + ui.item.label); // display the selected text        
       $("#emp_id").attr("value", ui.item.value);
       $('#designation').val(ui.item.designation);
       // console.log(ui.item.designation);
       // save selected id to input

       return false;
     }
   });
   $("#employee_2_search").autocomplete({
     source: function(request, response) {

       // Fetch data
       $.ajax({

         headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         url: "{{route('datafetch')}}",
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
       $('#employee_2_search').val(ui.item.label2 + '-' + ui.item.label); // display the selected text        
       $("#emp_2_id").attr("value", ui.item.value);
       $('#designation').val(ui.item.designation);
       // console.log(ui.item.designation);
       // save selected id to input

       return false;
     }
   });
 </script>