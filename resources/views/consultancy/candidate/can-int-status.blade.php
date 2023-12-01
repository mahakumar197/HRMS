@if ($int_status != null)
    <div class="row">
        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
        <lottie-player src="{{ asset('assets/json/int.json') }}" background="transparent" speed="1"
            style="width: 100%; height: 100%;" loop autoplay></lottie-player>
    </div>

    <div class="card">
        <div class="card-header bg-secondary pb-2">
            <div class="ribbon ribbon-bookmark ribbon-right ribbon-info">Active</div>
            <div class="blog-box blog-list row">
                <div class="blog-details">
                    <div class="blog-date"><span class="text-light">{{ $int_status->jobdetails->job_code }}</span>
                    </div>
                    <h6>{{ $int_status->jobdetails->position->position_name }}</h6>

                    <div class="blog-bottom-content">
                        <ul class="blog-social">
                            <li class="text-dark">Posted Date:
                                {{ Carbon::parse($int_status->jobdetails->job_posted_date)->format('M d Y') }}</li>
                            <li class="text-dark">Headcount : {{ $int_status->jobdetails->headcount }}</li>
                        </ul>
                        <hr>
                    </div>
                </div>
            </div>
        </div>

        <div class="widget-feedback card-body b-secondary p-0">
            <div class="row align-items-center">
                <div class="col-md-6 b-r-light">
                    @foreach ($int_name as $in)
                        <ul class='mt-0'>
                            <li class="font-roboto">
                                <h4 class="cursor_default">{{ $in }}</h4>
                                @if ($in == 'HR Interview')
                                    <a href="{{ url('consultancy/data-hr-feedback') }}/{{ $int_status->round_1_feedback }}"
                                        target="_blank">
                                        <h4 class="font-warning">Feedback</h4>
                                    </a>
                                @endif
                            </li>
                        </ul>
                    @endforeach
                </div>
                <div class="col-md-6">
                    @foreach ($int_result as $ir)
                        @if ($loop->first)
                        <ul class='mt-0 cursor_default border-top-0'>
                            <li>
                                <h4 class="font-success">{{ config('constants.interview_status.' . $ir) }}</h4>
                            </li>
                        </ul>
                        @else
                        <ul class='mt-0 cursor_default'>
                            <li>
                                <h4 class="font-success">{{ config('constants.interview_status.' . $ir) }}</h4>
                            </li>
                        </ul>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@else
    <div class="row">
        <img src="{{ asset('assets/css/images/no-data.jpg') }}" width='100%' ; height='100%' ; alt="no-data">
    </div>
    <div class="card bg-danger">
        <div class="card-body">
            <h2>{{ 'No Details To Display' }}</h2>
        </div>
    </div>
@endif
