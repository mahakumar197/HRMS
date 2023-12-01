 <div class="modal-header">
   <div class="media">
     <div class="media-body">
       <h6 class="f-w-600"><a href="javascript:void(0)">{{$feedback_get->candetails->name}}</a></h6>
       <p>{{$feedback_get->jobdetails->job_code}}</p>
       <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" data-bs-original-title="" title=""></button>
     </div>
   </div>
 </div>
 <div class="modal-body">
   <h5>Comment</h5>

   <p class="text-justify">{{$feedback_get->comments}}</p>



 </div>