 <h2 class="text-capitalize">{{$can_details->candetails->name}}
     <h2>
         <h4 class="m-b-20">{{$can_details->jobdetails->position_id}}
             <h4>





                 @for ($i = 2; $i < $round ; $i++) <div class="col-10 border rounded-3 m-b-20">
                     <div class="single-team h-calc">

                         <div class="d-flex align-items-center mb-10 border-bottom">


                             @php

                             $marge1 = 'roundname'.$i;

                             $d = $can_details->$marge1->round_name;

                             $status = 'round_'.$i.'_status';

                             $status = $can_details->$status;
                             @endphp



                             <div class="team-title">
                                 <span class="title font-600">Round- {{$i}} : {{ $d}} </span>
                                 <p class="pera">time</p>
                             </div>
                             <hr />
                         </div>

                         @switch($status);



                         @case(1)



                         <div class="d-flex align-items-center mb-10 border-bottom">
                             <div class="team-img">
                                 <img src="https://initcard.sai4ul.com/assets/images/team/user4.jpg" alt="img" class="img-cover">
                             </div>
                             <div class="team-title">
                                 <span class="title font-600 text-success">On Hold</span>


                             </div>
                         </div>


                         @php

                         $marge2 ='';

                         $d3 ='';

                         $marge2 = 'round_'.$i.'_feedback';

                         $d3 = $can_details->$marge2;

                         $f_type='';

                         $f_type = 'round_'.$i.'_feedback_type';

                         $f_type = $can_details->$f_type;


                         @endphp


                         <div class="team-cap text-center">
                             <a href="#" id="feedback_round_1" class="btn btn-outline-info " job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id=" {{$d3}}" round="{{$i}}" feedback_type="{{$f_type}}"> Feedback Form</a>

                         </div>



                         @break




                         @case(2)



                         <div class="d-flex align-items-center mb-10 border-bottom">
                             <div class="team-img">
                                 <img src="https://initcard.sai4ul.com/assets/images/team/user4.jpg" alt="img" class="img-cover">
                             </div>
                             <div class="team-title">
                                 <span class="title font-600 text-success">Selected</span>


                             </div>
                         </div>


                         @php



                         $marge = 'round_'.$i.'_feedback';

                         $d = $can_details->$marge;

                         $f_type = 'round_'.$i.'_feedback_type';

                         $f_type = $can_details->$f_type;


                         @endphp
                         <div class="team-cap text-center">
                             <a href="#" id="feedback_round_1" class="btn btn-outline-info " job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id=" {{$d}}" round="{{$i}}" feedback_type="{{$f_type}}"> Feedback Form</a>

                         </div>



                         @break






                         @default
                         <h5>Feed Back Not Found</h5>
                         @endswitch



                     </div>
                     </div>


                     @endfor



                     <script>
                         jQuery("[id^=feedback_round_]").click(function() {


                             var round = $(this).attr("round");

                             var job = $(this).attr("job_id");

                             var can_id = $(this).attr("can_id");

                             var round_id = $(this).attr("round_id");
                             var feedback_type = $(this).attr("feedback_type");


                             $.ajax({
                                 type: "GET",
                                 data: {
                                     'round': round,
                                     'job': job,
                                     'can_id': can_id,
                                     'round_id': round_id,
                                     'feedback_type': feedback_type
                                 },
                                 url: "{{ route('get-feedback-details') }}",
                                 success: function(data) {

                                     $('#modal-content').html(data);

                                     $('#schedule_modal').modal('show');

                                 }
                             });

                         });
                     </script>