 
<div class="modal-body"> 

  
<div class="job-search">
                    <div class="card-body p-0">
                      <div class="media"> 
                        <div class="media-body">
                          <h6 class="f-w-600"><a href="javascript:void(0)">{{$feedback_get->candetails->name}}                                    </a></h6>
                          <p>{{$feedback_get->jobdetails->job_code}}</p>
                      <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" data-bs-original-title="" title=""></button>
                        </div>
                      </div>
                       <div class="job-description">
                        <h6>General Comments</h6>
                        <p class="text-start"> {{$feedback_get->overall_comment}}<p>
                      </div>
                      <div class="job-description border-0">
                        

                        <table class="table table-responsive">
                      <thead class="table-light">
                        <tr>
                           
                          <th scope="col">Skill Name</th>
                          <th scope="col">Rating</th>
                          <th scope="col">Comment</th>
                          
                        </tr>
                      </thead>
                      <tbody>
                        
                        @foreach($skill as $s)
                        <tr>
                          
                          <td>{{$s->skillname->skillset}}</td>
                          <td> <select id="rating1" name="inputs_1" autocomplete="off">
                                                <option value="1" {{$s->rating == '1' ?'selected':''}}>1</option>
                                                <option value="2"{{$s->rating == '2' ?'selected':''}}>2</option>
                                                <option value="3"{{$s->rating == '3' ?'selected':''}}>3</option>
                                                <option value="4"{{$s->rating == '4' ?'selected':''}}>4</option>
                                                <option value="5"{{$s->rating == '5' ?'selected':''}}>5</option>
                                                <option value="6"{{$s->rating == '6' ?'selected':''}}>6</option>
                                                <option value="7"{{$s->rating == '7' ?'selected':''}}>7</option>
                                                <option value="8"{{$s->rating == '8' ?'selected':''}}>8</option>
                                                <option value="9"{{$s->rating == '9' ?'selected':''}}>9</option>
                                                <option value="10"{{$s->rating == '10' ?'selected':''}}>10</option>
                                            </select></td>
                         

                          <td>{{$s->comment}}</td>
                           
                           
                        </tr>
                         @endforeach
                        
                        
                        
                      </tbody>
                    </table>
                         


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

<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/rating.css')}}">


<script src="{{ asset('assets/js/rating/jquery.barrating.js')}}"></script>
<script src="{{ asset('assets/js/rating/rating-script.js')}}"></script>