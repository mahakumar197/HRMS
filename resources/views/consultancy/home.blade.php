@extends('layouts.consultancy.con-report')

@section('page_title')
<title>Dashboard</title>
@endsection
@section('style')

<style>
  .display1 tbody tr {
    box-shadow: 0px 4px 30px rgb(94 94 231 / 7%) !important;
  }

  .display1 tbody tr td {
    vertical-align: middle;
    padding: 25px 10px !important;
    border: none;
    /*border-bottom: 10px solid #f9f9f9;*/
  }

  .gfg {
    border-spacing: 0 15px !important;
    border: none !important;
    font-size: 15px !important;
  }

  .profile-greeting {
    background-color: #fff;
    color: var(--theme-deafult);
  }

  .profile-greeting .greeting-user p {
    color: #225588eb;
  }
</style>
@endsection

@section('content')
<div class="page-body">
  <div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-sm-6">

        </div>

      </div>
    </div>
  </div>
  <div class="container-fluid default-dash">
    <div class="row align-items-center">
      <div class="col-xl-6 col-md-6 dash-xl-50">
        <div class="card profile-greeting">
          <div class="card-body">
            <div class="media">
              <div class="media-body">
                <div class="greeting-user mb-2">
                  <h1>Hello, {{ Auth::guard('consultancy')->user()->consultancy_name }}</h1>
                  <p>Sword Welcomes You Back!</p><a class="btn btn-outline-primary" href="#">Get Started<i class="icon-arrow-right"> </i></a>
                </div>
              </div>
            </div>
            <div class="cartoon-img"><img class="img-fluid" src="{{asset('assets/css/images/we-are-hiring.webp')}}" alt="" width="360px"></div>
          </div>
        </div>
      </div>

      <div class="col-xl-4 col-md-4 dash-xl-33 dash-lg-50">
        <div class="card card-absolute">
          <div class="card-header card-no-border bg-info">
            <div class="header-top">
              <h5 class="m-0">Candidates</h5>
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordernone">
                <tbody>
                  @if(!empty($jobs))
                  @foreach ($jobs as $job)
                  <tr>
                    <td>
                      <div class="media">
                        <div class="icon-wrappar"><i class="fa fa-trophy font-primary"> </i></div>
                        <div class="media-body"><a href="#" data-bs-original-title="" title="">
                            <h5>{{$job->job_code}}</h5>
                          </a>
                          <p>{{$job->position->position_name}}</p>
                        </div>
                      </div>
                    </td>
                    @foreach($can_list as $key => $cl)

                    @if($job->id == $key)
                    <td><span class="badge badge-light-theme-light font-theme-light">{{count($cl)}}</span></td>
                    @endif
                    @endforeach
                  </tr>
                  @endforeach
                  @endif

                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>
    <div class="row mt-5">
      <div class="col-xl-12">
        @if(Session::has('message2'))
        <div class="alert alert alert-success" role="alert">
          {{session::get('message2')}}
        </div>
        @endif

        @if(Session::has('error'))
        <div class="alert alert alert-danger" role="alert">
          {{session::get('error')}}
        </div>
        @endif
        <div class="table-responsive">
          <table class="basic-1 display1 gfg" id="datatable" style="border-collapse: separate!important;">
            <thead class="bg-secondary">
              <tr>
                <th>S.No.</th>
                <th>Position Name</th>
                <th>Posted Date</th>
                <th>Job Code</th>
                <th>Headcount</th>
                <th>Exp. Req.</th>
                <th>Job Owner</th>
                <th>Job Status</th>
                <th>Add Candidate</th>
                <th>View Job Profile</th>
                <th>Job Description</th>
                <th>Candidate List</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- Container-fluid Ends-->

</div>
@endsection
@section('script')
<script>
  $(document).ready(function() {
    var table = $('#datatable').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": "{{ route('consultancy.api.getJob.conref') }}",
      'columnDefs': [{
          "targets": [8, 9, 10], // your case first column
          "className": "text-center",
        },
        {
          "width": "10%",
          "targets": 6
        }
      ],
      "columns": [{
          data: 'DT_RowIndex',
          name: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          "data": "position"
        },
        {
          "data": "job_posted_date",
          "render": function(data, type) {
            return type === 'sort' ? data : moment(data).format('DD-MM-Y');
          }
        },
        {
          "data": "job_code"
        },
        {
          "data": "headcount",
        },
        {
          "data": "experience_required",
        },
        {
          "data": "job_owner",
        },
        {
          "data": "job_status",
        },
        {
          "data": "action",
        },
        {
          "data": "view",
        },
        {
          "data": "jd_upload",
          "render": function(data, type, full, meta) {
            if(data != null){
              return "<a href=\"/jd/" + data + "\"  target = '_blank'>View/Download</a>";
            }
            else{
              return "-"
            }
            
          }          
        },
        {
          "data": "candidate_list",
        },
      ]
    });

  });
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx = document.getElementById('myChart');
  const lab = ['JOB_36', 'JOB_34'];
  const data = ['2', '1'];
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: lab,
      datasets: [{
        label: 'No. Of Candidates',
        data: data,
        borderWidth: 1,
        backgroundColor: [
          'rgba(54, 162, 235, 0.4)',
          'rgba(153, 102, 255, 0.4)',
          'rgba(255, 99, 132, 0.4)',
          'rgba(255, 159, 64, 0.2)',
          'rgba(255, 205, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)',
          'rgba(201, 203, 207, 0.2)'
        ],
        borderColor: [
          'rgb(54, 162, 235)',
          'rgb(153, 102, 255)',
          'rgb(255, 99, 132)',
          'rgb(255, 159, 64)',
          'rgb(255, 205, 86)',
          'rgb(75, 192, 192)',
          'rgb(201, 203, 207)'
        ],
      }],

    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>

@endsection