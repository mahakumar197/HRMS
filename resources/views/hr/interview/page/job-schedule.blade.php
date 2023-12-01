 <div class="modal-header">
   <h4 class="modal-title">{{$schedule_interview->jobdetails->job_code}} - {{$roundname}}</h4>
   <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" data-bs-original-title="" title=""></button>
 </div>
 <div class="modal-body">
   <div class="error_schedule mb-2"></div>
   <div class="success_schedule"></div>
   <div class="form theme-form projectcreate">
     <form action="#" method="POST" id="schedule_interview" autocomplete="off">
       @csrf
       <div class="row">
         <div class="col-12">
           <div class="mb-3">
             <label>Position Name*</label>
             <input class="form-control " type="text" placeholder="Position Name" value="{{$schedule_interview->jobdetails->position->position_name}}" disabled>
             <input class="form-control " type="hidden" placeholder="Position Name" name="job_id" id="job_id" value="{{$schedule_interview->job_id}}">
             <input class="form-control " type="hidden" name="ji" id="ji" value="{{$schedule_interview->id}}">
             <input class="form-control " type="hidden" name="round" value="{{$round}}">
             <input class="form-control " type="hidden" name="job_interview" value="{{$schedule_interview->id}}">
             <input class="form-control " type="hidden" name="round_id" value="{{$round_id}}">
           </div>
         </div>
       </div>
       <div class="row">
         <div class="col-sm-6">
           <div class="mb-3">
             <label>Attendee Name*</label>
             <input class="form-control " type="text" placeholder="Attendee Name" id="attendee_name" value="{{$schedule_interview->candetails->name}}" disabled>
             <input type="hidden" value='{{$schedule_interview->can_id}}' name='can_id' id="can_id" class="form-control" />
           </div>
         </div>
         <div class="col-sm-6">
           <div class="mb-3">
             <label>Attendee Email Id*</label>
             <input class="form-control " type="email" placeholder="Attendee Email" name="attendee_email" value="{{$schedule_interview->candetails->email}}" disabled>
           </div>
         </div>
       </div>
       <div class="row">
         <div class="col-6">
           <div class="mb-3">
             <label>Interviewer Name*</label>
             <div class="form-group">
               <input type="text" value='' id='employee_search' class="typeahead form-control input-lg {{ $errors->has('interviewer_id') ? ' has-error' : ''}}" placeholder="Interviewer Name" />
               <input type="hidden" name="interviewer_id" value='' id='emp_id' class="form-control input-lg" placeholder="Employee Name" />
               @if ($errors->has('interviewer_id'))
               <div class="text-danger">{{ $errors->first('interviewer_id') }}</div>
               @endif
             </div>
           </div>
         </div>
         <div class="col-6">
           <div class="mb-3">
             <label>Second Interviewer Name</label>
             <div class="form-group">
               <input type="text" value='' id='employee_2_search' class="typeahead form-control input-lg {{ $errors->has('interviewer_2_id') ? ' has-error' : ''}}" placeholder="Interviewer Name" />
               <input type="hidden" name="interviewer_2_id" value='' id='emp_2_id' class="form-control input-lg" placeholder="Employee Name" />
               @if ($errors->has('interviewer_2_id'))
               <div class="text-danger">{{ $errors->first('interviewer_2_id') }}</div>
               @endif
             </div>
           </div>
         </div>
       </div>
       <div class="row">
         <div class="col-sm-6">
           <div class="mb-3">
             <label>Interview Date*</label>
             <input class="datepicker-here form-control digits" id="past_date" placeholder="DD-MM-YYYY" type="text" data-language="en" name="schedule_date">
           </div>
         </div>
         <div class="col-sm-6">
           <div class="mb-3">
             <label>Interview Time*</label>
             <div class="input-group date" id="dt-time" data-target-input="nearest">
               <input class="form-control datetimepicker-input digits" type="text" data-target="#dt-time" name="schedule_time">
               <div class="input-group-text" data-target="#dt-time" data-toggle="datetimepicker"><i class="fa fa-clock-o"></i></div>
             </div>
           </div>
         </div>
       </div>
       <div class="row">
         <div class="col-sm-6">
           <div class="mb-3">
             <label>Interview Type*</label>
             <select class="form-select " name="interview_type" id="int_type">
               <option value="">Select</option>
               <option value="Telephonic Interview">Telephonic Interview</option>
               <option value="Skype">Skype</option>
               <option value="Google Meet">Google Meet</option>
               <option value="Microsoft Teams">Microsoft Teams</option>
               <option value="Face to Face">Face to Face</option>
             </select>
           </div>
         </div>
         <div class="col-sm-6 meeting_link">
           <div class="mb-3">
             <label>Meeting Link*</label>
             <input class="form-control " type="text" placeholder="Meeting Link" name="meeting_link" value="">
           </div>
         </div>
       </div>
       <div class="row">
         <div class="col">
           <div class="loading"></div>
           <div class="text-right"> <button class="btn btn-primary me-3" type="submit" id="schedule_submit"> Schedule </button>
             <a href="#" data-bs-dismiss="modal" aria-label="Close" class="btn btn-secondary me-3 " id="cancel">Cancel</a>
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
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
 <style rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/smoothness/jquery-ui.min.css"></style>


 <script>
   $('#schedule_interview').on('submit', function(event) {
     event.preventDefault();
     var can_id = $('#can_id').val();
     var job_id = $('#job_id').val();
     var ji = $('#ji').val();
     $.ajax({
       url: '{{url("job-schedule")}}',
       method: 'POST',
       data: $(this).serialize(),
       dataType: 'json',
       beforeSend: function() {
         $('#schedule_submit').attr('disabled', 'disabled');
         $('#cancel').attr('disabled', 'disabled');
         $('#mail_send').append('<div class="loader-wrapper" style="opacity: 0.980147;"><div class="loader"><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-ball"></div></div></div>');
       },
       success: function(data) {
         var details = '<div class="alert alert-success dark alert-dismissible fade show" role="alert">' + data.success + ' <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button></div>'
         $('.success_schedule').html(details);
         $('#mail_send').empty();
         getcandetails(ji, job_id);
         $(":submit").removeAttr("disabled");
         $('#cancel').removeAttr("disabled");
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
         $('#cancel').removeAttr("disabled");
       }
     })
   });
 </script>

 <script>
   function getMoreUsersagian(can_id, job_id) {
     console.log('working');
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

   /*---------------------On Select------------------*/

   $(function() {
     $('#int_type').change(function() {
       if ($(this).val() == 'Telephonic Interview' || $(this).val() == 'Face to Face') {
         $('.meeting_link').hide();
       } else {
         $('.meeting_link').show();
       }

     });
   });
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
           console.log(data);
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
           console.log(data);
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