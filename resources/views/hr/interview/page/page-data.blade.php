@foreach($candidate as $can)

<div class="col-sm-12">
  <div class="card">
    <div class="card-header">
      <h5>{{$can->candetails->name}}</h5>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Name</th>
              <th scope="col">Resume</th>
              <th scope="col">Current Position</th>
                           
              <th scope="col">Details</th>

            </tr>
          </thead>
          <tbody>
            <tr>

              <td>{{$can->candetails->name}}</td>
                          <td><a href="resume/{{$can->candetails->resume_upload}}"   target = '_blank'>View/Download</a></td>

              <td>{{$can->jobdetails->job_code}}</td>

              @if(is_null($can->round_1_status))

              <td>
                <h5><a href="#" class="btn btn-success" id="schedulejob_{{$can->id}}" job_id="{{$can->job_id}}" round="round_1" roundname="{{$can->roundname1->round_name}}">Schedule Now</a></h5>
              </td>


              @else

              @switch($can->round_1_status)

              @case(0)
              <td><a href="#" class="btn btn-primary">Schduled</a></td>
              @break

              @case(1)
              <td><a href="#" class="btn btn-primary">On Hold</a></td>
              @break

              @case(2)
              <td><a href="#" class="btn btn-danger">Selected</a></td>
              @break

              @case(3)
              <td><a href="#" class="btn btn-danger">Rejected</a></td>
              @break




              @default
              <td>no</td>
              @endswitch

              @endif

              <td><a herf="#" class="btn btn-primary" id="details_{{$can->can_id}}" job_id="{{$can->job_id}}"> View Details</a></td>

            </tr>




          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


@endforeach

 


<div class="">
  {!! $candidate->links() !!}
</div>