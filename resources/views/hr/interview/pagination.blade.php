@extends('layouts.report')
@section('page_title')
<title>Interview123</title>
@endsection

@section('content')

<div class="page-body">
<div class="container-fluid pt-200">
        <div class="col-sm-12 col-xl-12 xl-100">
            <div id="page-data">
               
                   @include('hr.interview.page.page-data')
            </div>
        </div>



    </div>
</div>
@endsection


@section('script')
<script>
 $(document).ready(function() {
        $(document).on('click', '.pagination a', function(event) {
          event.preventDefault();
          var page = $(this).attr('href').split('page=')[1];
           
          getMoreUsers(page);
        });
 

    });


    function getMoreUsers(page) {

     
      $.ajax({
        type: "GET",
        data: {},
        url: "{{ route('get-more-candidate') }}" + "?page=" + page,
        success:function(data) {


          $('#page-data').html(data);
        }
      });
    }
</script>
@endsection

 