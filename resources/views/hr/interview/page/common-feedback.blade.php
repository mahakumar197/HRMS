 <div class="modal-body"> 

  
<div class="job-search ">
                    <div class="card-body p-0">
                      <div class="media"> 
                        <div class="media-body">
                          <h6 class="f-w-600"><a href="javascript:void(0)">{{$feedback_get->candetails->name}}                                    </a></h6>
                          <p>{{$feedback_get->jobdetails->job_code}}</p>
                      <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" data-bs-original-title="" title=""></button>
                        </div>
                      </div>
                       <div class="job-description">
                        <h6> Comment </h6>
                        <p class="text-start"> {{$feedback_get->comment}}<p>
                      </div>
                      

                      @if(isset($feedback_get->can_image))
                      <div class="job-description border-0">

                        <h6>Uploaded Image</h6>

                           <img class="img-100 rounded-circle" src="{{ asset('interview_image/')}}/{{$feedback_get->can_image}}" alt="#"> 

                      </div>
                     
                      @endif
                      
                      
                    </div>
                  </div>

</div>




  