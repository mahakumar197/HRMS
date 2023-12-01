@extends('layouts.app')
@section('content')


<div class="page-body">

<div class="container-fluid">
    <div class="row project-cards justify-content-center">
      <div class="col-md-10 project-list">

        <div class="row">
        <div class="card">
        <div class="card-header">



<span class="pull-right"><button id="export" class="btn btn-primary  exportToExcel"
                                        style="float: right;">Download Excel</button></span>
</div>

            
            <table class="table" id="ent">
                <tbody>
                    <thead>
                        <th>Employee Code</th>
                        <th>Name</th>
                        <th>CL</th>
                        <th>PL</th>
                        <th>SL</th>
                    </thead>



                    <tr>
                        @foreach($entitlements as $key =>  $entitlement)
                        @foreach ($emp as $e)
                        @if($e->id == $key)
                        <td>{{$e->employee_code}}</td>
                        <td>{{$e->name}}</td>
                        @break
                        @endif

                        @endforeach

                        @foreach ($entitlement as $ent )
                       <td>{{$ent->balance}}</td>

                        @endforeach

                    </tr>
                    @endforeach


                </tbody>
            </table>
        </div>

          </div>

      </div>

    </div>

  </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/jquery.tableTotal.js') }}"></script>

<script src="{{ asset('js/tableToExcel.js') }}"></script>
<script>


        $("#export").click(function() {

            TableToExcel.convert(document.getElementById("ent"), {
                name: "entitlement"+".xlsx",
                sheet: {
                    name: "Sheet 1"
                }
            });


        });
    </script>
@endsection
