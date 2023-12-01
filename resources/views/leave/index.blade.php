@extends('layouts.report')
@section('page_title')
<title>Leave Summary</title>
@endsection
@section('style')
<style>
  .switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 15px;
  }

  .switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }

  .slider {
    position: absolute;
    cursor: pointer;
    top: 10px;
    left: 4px;
    right: 0;
    bottom: 0;
    background-color: #9acafb;
    -webkit-transition: .4s;
    transition: .4s;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 24px;
    width: 24px;
    left: 0px;
    bottom: -2px;
    background-color: #f9f9f9;
    -webkit-transition: .4s;
    transition: .4s;
    box-shadow: 0 0 2px rgb(0 0 0 / 45%);
  }

  input:checked+.slider {
    background-color: #c9c9c9;
  }

  input:focus+.slider {
    box-shadow: 0 0 1px #2196F3;
  }

  input:checked+.slider:before {
    -webkit-transform: translateX(26px);
    -ms-transform: translateX(26px);
    transform: translateX(26px);

  }

  /* Rounded sliders */
  .slider.round {
    border-radius: 34px;
    height: 20px;
    width: 50px;
  }

  .slider.round:before {
    border-radius: 50%;
  }

  .table thead th {
    font-weight: 600;
    color: #225588;
  }
</style>
@endsection

@section('content')

<div class="page-body">
  <div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-sm-6">
          <h3>Leave Summary</h3>
        </div>

        <div class="col-12 col-sm-6">
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
        </div>
      </div>
    </div>
  </div>
  <div class="container my-5">
  </div>
  <div class="container-fluid">
    <div class="row project-cards justify-content-center">
      <div class="col-md-10 project-list">

        <div class="row">
          @foreach ($entitlements as $entitlement)
          @if($entitlement != null && $entitlement->leaveType !="LOP")
          <div class="col-sm-6 col-xl-4 col-lg-6">
            <div class="card o-hidden">
              <div class="card-body">
                <div class="media static-widget">
                  <div class="media-body">
                    @if($entitlement->leaveType=="CL")
                    <h3> Casual Leave</h3>
                    @elseif($entitlement->leaveType=='PL')
                    <h3>Privilege Leave</h3>
                    @elseif($entitlement->leaveType=='SL')
                    <h3>Sick Leave</h3>
                    @endif
                    </h3>
                    <h5 class="mb-0 counter">Available: {{$entitlement->balance}}</h5>                                        
                    <h5 class="mb-0 counter">Approval Pending: {{$entitlement->pending}}</h5>
                    <h5 class="mb-0 counter">Used: {{$entitlement->used}}</h5>
                  </div>
                  @if($entitlement->leaveType=="CL")
                  <svg version="1.1" class="fill-secondary" width="48" height="48" x="0px" y="0px" viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve">
                    <g>
                      <path d="M985,802.7c-19.6-86-59.6-145.2-119.6-189c-14.9-10.9-30.7-20.4-48.4-28.5c-6.3-2.7-12.7-5.5-19-8.2c0-0.1,0-0.2,0-0.3c7.8-8.8,18.8-14.4,26.1-23.8c17.1-22.1,31.5-43.6,40.5-74.7c10.3-35.4,5.8-83-5.7-112.9c-24.3-63.3-81.9-117.8-168.3-116.1c-4.4,0.3-8.9,0.6-13.3,0.9c-10.4,1.9-20.4,3-29.7,5.9c-36.3,11.3-67.1,31.8-87.8,59.4c-17,22.7-29.7,47.8-36.8,81.1c-9.8,46.2,4.1,95.7,20.7,124.4c5.7,9.8,12.6,18.4,19.3,27c6,7.8,21.3,24.4,30,28.5c0,0.1,0,0.2,0,0.3c-7.3,3.1-14.5,6.3-21.8,9.4c-15.8,7.2-31.2,16.5-44.8,26.5c-51.4,37.6-91.8,89.5-112.8,158.5c-3.8,12.6-5.9,25.2-8.8,39.1c-5.3,25.8-4.5,57.8-4.5,89.1c0,17-0.8,32.5,6.2,41.7c7.8,10.3,23.2,9.1,41.1,9.1c30.7,0,61.4,0,92.1,0c102.4,0,204.7,0,307.1,0c29.3,0,58.6,0,87.8,0c12.8,0,31,2.2,40.5-2.1c17-7.6,14.7-23.9,14.7-48.5C989.9,865.6,991.3,830.2,985,802.7z M570.5,471c-5.2-15.4-9.1-40.4-5.1-60.8c1.7-8.8,3.1-17.5,6-25.3c14.8-39.4,40.7-66.9,78.7-82.3c8.1-3.3,17.2-5,26.4-6.9c4.3-0.4,8.6-0.8,12.9-1.2c66.6-0.2,106.7,34.8,126.8,82.9c12.3,29.6,13.8,72.1,1.2,102.9c-15.5,38-43.9,66.3-83.5,79.2c-9.3,3-19.2,3.7-30,5.6c-19.3,3.4-44.9-4.5-57.1-9.7C609.1,539.5,584.4,511.9,570.5,471z M952.6,904.9c-171.4,0-342.8,0-514.2,0c0-28-1.5-57.8,3.3-81.4c18.5-91.2,64.1-148.3,131.1-188.8c19.7-12,43.1-19.7,67.9-26.1c59.3-15.4,127.5,0.1,168.5,21.7c71.8,37.9,119.9,98.2,139.5,190.4C953.9,844.9,952.9,875.6,952.6,904.9z" />
                      <path d="M330.1,757.4C173.3,729.7,54.3,592.8,54.3,428.1C54.3,243.4,204,93.7,388.7,93.7c90.6,0,172.7,36,232.9,94.5l42.8-19.6c-69.1-73.4-167-119.2-275.7-119.2C179.5,49.4,10,219,10,428.1C10,606.2,132.9,755.5,298.5,796L330.1,757.4z" />
                      <path d="M411.5,246.6c0-12.5-10.2-22.7-22.7-22.7c-12.5,0-22.7,10.2-22.7,22.7v168.9l-93.7,93.7c-8.9,8.9-8.9,23.2,0,32.1s23.2,8.9,32.1,0L404.8,441c2.6-2.6,4.5-5.8,5.5-9.1c0-0.1,0.1-0.2,0.1-0.3c0.2-0.6,0.3-1.2,0.4-1.7c0-0.1,0.1-0.3,0.1-0.4c0.1-0.6,0.2-1.2,0.3-1.8c0-0.1,0-0.3,0.1-0.4c0.1-0.8,0.1-1.5,0.1-2.3c0,0,0,0,0,0V246.6z" />
                    </g>
                  </svg>
                  @elseif($entitlement->leaveType=='PL')
                  <svg version="1.1" class="fill-secondary" width="48" height="48" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve">
                    <g>
                      <path d="M769.7,361.9H278.2c-6.9,0-12.5,5.6-12.5,12.5c0,6.9,5.6,12.5,12.5,12.5h491.5c6.9,0,12.5-5.6,12.5-12.5C782.2,367.5,776.6,361.9,769.7,361.9z" />
                      <path d="M769.7,503.9H579.8c-6.9,0-12.5,5.6-12.5,12.5c0,6.9,5.6,12.5,12.5,12.5h189.9c6.9,0,12.5-5.6,12.5-12.5C782.2,509.4,776.6,503.9,769.7,503.9z" />
                      <path d="M769.7,645.8H646.5c-6.9,0-12.5,5.6-12.5,12.5c0,6.9,5.6,12.5,12.5,12.5h123.3c6.9,0,12.5-5.6,12.5-12.5C782.2,651.4,776.6,645.8,769.7,645.8z" />
                      <path d="M392.5,88.2h257.1c6.9,0,12.5-5.6,12.5-12.5c0-6.9-5.6-12.5-12.5-12.5H392.5c-6.9,0-12.5,5.6-12.5,12.5C380,82.7,385.7,88.2,392.5,88.2z" />
                      <path d="M323.1,145.5c6.9,0,12.5-5.6,12.5-12.5V22.5c0-6.9-5.6-12.5-12.5-12.5c-6.9,0-12.5,5.6-12.5,12.5V133C310.6,139.9,316.2,145.5,323.1,145.5z" />
                      <path d="M719.1,145.5c6.9,0,12.5-5.6,12.5-12.5V22.5c0-6.9-5.6-12.5-12.5-12.5c-6.9,0-12.5,5.6-12.5,12.5V133C706.6,139.9,712.2,145.5,719.1,145.5z" />
                      <path d="M835.6,63.2h-43.5c-6.9,0-12.5,5.6-12.5,12.5c0,6.9,5.6,12.5,12.5,12.5h43.5c48.9,0,88.8,39.8,88.8,88.8v29.5H123.6V177c0-48.9,39.8-88.8,88.8-88.8h42.6c6.9,0,12.5-5.6,12.5-12.5c0-6.9-5.6-12.5-12.5-12.5h-42.6c-62.7,0-113.8,51-113.8,113.8v410.5C44.3,663.2,33.8,765.8,79,852.9c3.2,6.1,10.7,8.5,16.8,5.3c6.1-3.2,8.5-10.7,5.3-16.9c-55.2-106.4-18.1-238.7,84.5-301c107.9-65.6,249-31.2,314.7,76.7c31.8,52.3,41.3,113.8,26.8,173.2c-14.5,59.4-51.3,109.7-103.6,141.5c-82.6,50.2-188.5,43-263.5-18c-2.4-2-4.9-4.1-7.3-6.2c-5.2-4.6-13.1-4.1-17.6,1c-4.6,5.2-4.1,13.1,1,17.6c2.7,2.4,5.4,4.7,8.1,6.9c46.3,37.6,103.2,56.8,160.3,56.8c45.5,0,91.2-12.2,131.9-36.9c5.5-3.3,10.8-6.8,15.9-10.5c1.2,0.4,2.4,0.6,3.8,0.6h379.4c62.7,0,113.8-51,113.8-113.7V177C949.4,114.3,898.3,63.2,835.6,63.2z M835.6,918.3H481.7c34-32.9,58.2-74.9,69.7-122c16.1-65.9,5.5-134.2-29.7-192.2c-72.8-119.6-229.3-157.9-349-85.1c-18.3,11.1-34.7,24.2-49.1,38.9V231.5h800.8v598C924.4,878.5,884.6,918.3,835.6,918.3z" />
                      <path d="M294.1,611.8c-6.9,0-12.5,5.6-12.5,12.5v126c0,5.1,3.1,9.8,7.9,11.7l129.8,50.8c1.5,0.6,3,0.9,4.5,0.9c5,0,9.7-3,11.6-8c2.5-6.4-0.7-13.7-7.1-16.2l-121.8-47.7V624.3C306.6,617.3,301,611.8,294.1,611.8z" />
                    </g>
                  </svg>
                  @elseif($entitlement->leaveType=='SL')
                  <svg class="fill-secondary" width="48" height="48" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve">
                    <g>
                      <path d="M133.4,488.5h352.1v40.8H133.4V488.5L133.4,488.5z" />
                      <path d="M289,332.9h40.8V685H289V332.9z" />
                      <path d="M84.9,849C43.6,849,10,815.4,10,774.1V243.7c0-29,17-55.6,43.3-67.9c10.2-4.8,22.3-0.4,27.1,9.9c4.8,10.2,0.4,22.3-9.9,27.1c-12,5.6-19.7,17.7-19.7,30.9v530.5c0,18.8,15.3,34,34,34c11.3,0,20.4,9.1,20.4,20.4S96.1,849,84.9,849z" />
                      <path d="M462.6,828.6H84.9H462.6z" />
                      <path d="M915.1,264.1c-11.3,0-20.4-9.1-20.4-20.4c0-18.8-15.3-34-34-34H175.6c-11.3,0-20.4-9.1-20.4-20.4c0-11.3,9.1-20.4,20.4-20.4h685.1c41.3,0,74.9,33.6,74.9,74.9C935.6,254.9,926.4,264.1,915.1,264.1z" />
                      <path d="M894.7,243.7h40.8v203.4h-40.8V243.7z" />
                      <path d="M633.8,204c-11.3,0-20.4-9.1-20.4-20.4v-53.9c0-18.8-15.3-34-34-34H366.2c-18.8,0-34,15.3-34,34v52.8c0,11.3-9.1,20.4-20.4,20.4c-11.3,0-20.4-9.1-20.4-20.4v-52.8c0-41.3,33.6-74.9,74.9-74.9h213.2c41.3,0,74.9,33.6,74.9,74.9v53.9C654.2,194.9,645.1,204,633.8,204z" />
                      <path d="M746.7,945.1c-134.2,0-243.3-109.1-243.3-243.3c0-134.1,109.1-243.3,243.3-243.3c134.2,0,243.3,109.1,243.3,243.3C990,836,880.8,945.1,746.7,945.1z M746.7,499.4c-111.6,0-202.5,90.8-202.5,202.4c0,111.6,90.8,202.5,202.5,202.5c111.6,0,202.5-90.8,202.5-202.5C949.2,590.2,858.3,499.4,746.7,499.4z" />
                      <path d="M746.7,677c-39.6,0-71.7-32.2-71.7-71.7c0-39.6,32.2-71.8,71.7-71.8c39.6,0,71.7,32.2,71.7,71.8C818.4,644.8,786.3,677,746.7,677z M746.7,574.3c-17,0-30.9,13.9-30.9,30.9c0,17,13.9,30.9,30.9,30.9s30.9-13.9,30.9-30.9C777.6,588.2,763.8,574.3,746.7,574.3z" />
                      <path d="M839.6,836.4H653.8c-26.3,0-47.6-21.4-47.6-47.6v-13.8c0-26.3,21.4-47.6,47.6-47.6h185.8c26.3,0,47.6,21.4,47.6,47.6v13.8C887.2,815,865.9,836.4,839.6,836.4z M653.8,768.1c-3.7,0-6.8,3.1-6.8,6.8v13.8c0,3.7,3.1,6.8,6.8,6.8h185.8c3.7,0,6.8-3.1,6.8-6.8v-13.8c0-3.7-3.1-6.8-6.8-6.8H653.8z" />
                      <path d="M810.2,768.1c-0.2,0-0.4,0-0.5,0h-126c-7.6,0-14.6-4.2-18.1-10.9c-3.5-6.7-3-14.8,1.3-21.1l63-91.1c7.6-11,26-11,33.6,0l60.7,87.9c3.9,3.7,6.4,9,6.4,14.8C830.6,759,821.5,768.1,810.2,768.1z M722.7,727.3h48.1l-24-34.8L722.7,727.3z" />
                    </g>
                  </svg>
                  @endif
                </div>
                <div class="progress-widget">
                  <div class="progress sm-progress-bar progress-animate">
                  @if($entitlement->entitlement !=0)  
                  <div class="progress-gradient-secondary" role="progressbar" style="width: {{($entitlement->used / $entitlement->entitlement)*100}}%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"><span class="animate-circle"></span></div>
                @endif  
                </div>
                </div>
              </div>
            </div>
          </div>
          @endif
          @endforeach



        </div>
        <div class="card">
          <div class="row">
            <div class="col-md-6 p-0">
              <div>
                <span class="text-primary h5">Upcoming</span>
                <label class="switch">
                  <input type="checkbox" name="graduate">
                  <span class="slider round"></span>
                </label>
                <span class="h5">History</span>
              </div>
            </div>
            <div class="col-md-6 p-0">
              <div class="form-group mb-0 me-0"></div><a class="btn btn-primary" href="{{url('leave/create')}}"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square">
                  <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                  <line x1="12" y1="8" x2="12" y2="16"></line>
                  <line x1="8" y1="12" x2="16" y2="12"></line>
                </svg>Apply Leave</a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-10">
        <div class="card">
          <div class="card-body">
            <div class="col-md-12 ug mt-5">
              <div class="table-responsive">
                <table class="display basic-1 " id="datatable">
                  <thead>
                    <tr>
                      <th>S.No.</th>
                      <th>From Date</th>
                      <th>To Date </th>
                      <th>Leave Type</th>
                      <th>No. of Days</th>
                      <th>Leave Reason</th>
                      <th>Remarks</th>
                      <th>Leave Status</th>
                      <th>Cancel Leave</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="col-md-12 mt-5 phd" style="display: none">
              <div class="table-responsive">
                <table class="display basic-1 " id="datatable_history">
                  <thead>
                    <tr>
                      <th>S.No.</th>
                      <th>From Date</th>
                      <th>To Date </th>
                      <th>Leave Type</th>
                      <th>No. of Days</th>
                      <th>Leave Reason</th>
                      <th>Remarks</th>
                      <th>Leave Status</th>
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
        <form action=" #" method='POST' id="edit_form" autocomplete="off">
          @csrf

          <div class="form-group">
            <label for="message-text" class="col-form-label" id="title"></label>
            <textarea class="form-control" id="message-text" name="remarks"></textarea>
            <input type="hidden" class="l_id" name="id">
          </div>

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>

@endsection

@section('script')
<script>
  $(document).ready(function() {
    $('[name="graduate"]').change(function() {
      if ($('[name="graduate"]:checked').is(":checked")) {
        $('.ug').hide();
        $('.phd').show();
      } else {
        $('.ug').show();
        $('.phd').hide();
      }
    });
  });
</script>


<script>
  $(document).ready(function() {

    $('#datatable').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": "{{ route('api.leaves.index') }}",
      'order':[1,'DESC'],
      "columns": [
        {
          data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false 
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
          "data": "leave_type"
        },
        {
          "data": "noOfDayDeduct"
        },
        {
          "data": "leaveReason"
        },
        {
          "data": "remarks"
        },
        {
          "data": "leaveStatus"
        },
        {
          "data": "cancelLeave",
        },
        {
          "data": "action",
        },

      ]
    });

    $('#datatable_history').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": "{{ route('api.leaveshistory.index') }}",
      "order":[1,'DESC'],
      "columns": [
        {
          data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false 
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
          "data": "leave_type"
        },
        {
          "data": "noOfDayDeduct"
        },
        {
          "data": "leaveReason"
        },
        {
          "data": "remarks"
        },
        {
          "data": "leaveStatus"
        },

        {
          "data": "action",
        },


      ]
    });




  });
</script>

<script>
  let $modal = $('#exampleModal');

  function testFunction_cancel(event, id) {
    event.preventDefault();
    $("#edit_form").attr('action', "{{url('cancel')}}");
    $('#userid').attr(id);
    $('#title').html('Reason For Leave Cancel');
    $modal.modal('show');
    $('.l_id').val(id);

  }
</script>



@endsection