<h2 class="text-capitalize">{{$can_data->name}}</h2>
<h4 class="m-b-20">{{$can_data->job->position->position_name}}</h4>


@if($details)

@if(is_null($details->offer_letter) && $details->document_verified == 'Yes')


<!-------------------------------------------------------------------->
<div class="card our-activities">
    <div class="card-body b-b-success">
        <div class="table-responsive">
            <table class="table table-bordernone">
                <tbody>
                    <tr>
                        <td>
                            <div class="media">
                                <div class="icon-wrappar"><i class="fa fa-files-o text-primary"></i></div>
                                <div class="media-body"><a href="#" data-bs-original-title="" title="">
                                        <h5 class="text-dark">Document Verified : <span class="f-18 {{$details->document_verified == 'Yes'?'font-success':'font-danger'}}">{{$details->document_verified}}</span></h5>
                                    </a>
                                    <p>{{substr($details->dv_comment,0,10)}} <a class="example-popover" data-bs-trigger="hover" data-container="body" data-bs-toggle="popover" data-bs-placement="bottom" title="" data-offset="-20px -20px" data-bs-content="{{$details->dv_comment}}" data-bs-original-title="Document Verification" aria-describedby="popover790891">...Read More</a></p>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge badge-light-primary">{{Carbon::parse($details->dv_date)->format('d M Y')}}</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!--------------------------------------------------------------------------->

<div class="card  b-secondary">
    <div class="card-header b-b-secondary">
        <div class="media">
            <div class="media-body">
                <h5 class="mb-0">Offer Letter</h5>
            </div>
        </div>
        <div class="error_schedule mb-2"></div>
        <div class="success_schedule"></div>
    </div>
    <div class="card-body">
        <form action="#" method="#" id="offer_letter" autocomplete="off">
            @csrf
            <div class="row">
                <div class="col-sm-12">
                    <div class="mb-3">
                        <label>Offer Letter Sent*</label>
                        <div class="col">
                            <div class="m-t-15 m-checkbox-inline custom-radio-ml">
                                <div class="form-check form-check-inline radio radio-primary">
                                    <input class="form-check-input" id="radioinline1" type="radio" name="ols" value="Yes">
                                    <label class="form-check-label mb-0" for="radioinline1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline radio radio-primary">
                                    <input class="form-check-input" id="radioinline2" type="radio" name="ols" value="No">
                                    <label class="form-check-label mb-0" for="radioinline2">No</label>
                                </div>
                            </div>
                        </div>
                        @if ($errors->has('ols'))
                        <div class="text-danger">{{ $errors->first('ols') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label>Sent Date*</label>
                        <input class="datepicker-here form-control {{ $errors->has('ols_date') ? ' has-error' : ''}}" readonly type="text" data-position="top right" placeholder="DD-MM-YYYY" value="{{old('ols_date')}}" name="ols_date">
                        @if ($errors->has('ols_date'))
                        <div class="text-danger">{{ $errors->first('ols_date') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label>Comments</label>
                        <textarea type="text" name="olscomment" value="{{old('olscomment')}}" placeholder="Enter comments if any" class="form-control {{ $errors->has('olscomment') ? ' has-error' : ''}}"></textarea>
                        @if ($errors->has('olscomment'))
                        <div class="text-danger">{{ $errors->first('olscomment') }}</div>
                        @endif
                        <input class="form-control " type="hidden" name="can_id" id="can_id" value="{{$can_data->id}}">
                        <input class="form-control " type="hidden" name="job_id" id="job_id" value="{{$can_data->job_id}}">
                        <input class="form-control " type="hidden" name="id" id="id_joc" value="{{$details->id}}">
                        <input class="form-control " type="hidden" name="process" id="process" value="2">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="text-left"> <button class="btn btn-primary me-3" type="submit"> Add </button></div>
                </div>
            </div>
        </form>
    </div>
</div>


@elseif(is_null($details->offer_ack) && $details->offer_letter == 'Yes')


<!-------------------------------------------------------------------->
<div class="card our-activities">
    <div class="card-body b-b-success">
        <div class="table-responsive">
            <table class="table table-bordernone">
                <tbody>
                    <tr>
                        <td>
                            <div class="media">
                                <div class="icon-wrappar"><i class="fa fa-files-o text-primary"></i></div>
                                <div class="media-body"><a href="#" data-bs-original-title="" title="">
                                        <h5 class="text-dark">Document Verified : <span class="f-18 {{$details->document_verified == 'Yes'?'font-success':'font-danger'}}">{{$details->document_verified}}</span></h5>
                                    </a>
                                    <p>{{substr($details->dv_comment,0,10)}} <a class="example-popover" data-bs-trigger="hover" data-container="body" data-bs-toggle="popover" data-bs-placement="bottom" title="" data-offset="-20px -20px" data-bs-content="{{$details->dv_comment}}" data-bs-original-title="Document Verification" aria-describedby="popover790891">...Read More</a></p>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge badge-light-primary">{{Carbon::parse($details->dv_date)->format('d M Y')}}</span></td>
                    </tr>
                    <tr>
                        <td style="white-space:wrap">
                            <div class="media">
                                <div class="icon-wrappar"><i class="fa fa-check-circle font-secondary"> </i></div>
                                <div class="media-body"><a href="#" data-bs-original-title="" title="">
                                        <h5 class="font-dark">Offer Letter Relesed: <span class="f-18 {{$details->offer_letter == 'Yes'?'font-success':'font-danger'}}">{{$details->offer_letter}}</span></h5>
                                    </a>
                                    <p>{{substr($details->ol_comment,0,10)}} <a class="example-popover" data-bs-trigger="hover" data-container="body" data-bs-toggle="popover" data-bs-placement="bottom" title="" data-offset="-20px -20px" data-bs-content="{{$details->ol_comment}}" data-bs-original-title="Offer Letter Relesed" aria-describedby="popover790891">...Read More</a></p>

                                </div>
                            </div>
                        </td>
                        <td><span class="badge badge-light-secondary">{{Carbon::parse($details->ol_date)->format('d M Y')}}</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!--------------------------------------------------------------------------->


<div class="card  b-secondary">
    <div class="card-header b-b-secondary">
        <div class="media">
            <div class="media-body">
                <h5 class="mb-0">Offer Letter Acknowledge</h5>
            </div>
        </div>
        <div class="error_schedule mb-2"></div>
        <div class="success_schedule"></div>
    </div>
    <div class="card-body">
        <form action="#" method="#" id="offer_letter" autocomplete="off">
            @csrf
            <div class="row">
                <div class="col-sm-12">
                    <div class="mb-3">
                        <label>Offer Letter Acknowledge*</label>
                        <div class="col">
                            <div class="m-t-15 m-checkbox-inline custom-radio-ml">
                                <div class="form-check form-check-inline radio radio-primary">
                                    <input class="form-check-input" id="radioinline1" type="radio" name="ola" value="Yes">
                                    <label class="form-check-label mb-0" for="radioinline1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline radio radio-primary">
                                    <input class="form-check-input" id="radioinline2" type="radio" name="ola" value="No">
                                    <label class="form-check-label mb-0" for="radioinline2">No</label>
                                </div>
                            </div>
                        </div>
                        @if ($errors->has('ola'))
                        <div class="text-danger">{{ $errors->first('ola') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label>Acknowledge Date*</label>
                        <input class="datepicker-here form-control {{ $errors->has('ola_date') ? ' has-error' : ''}}" readonly type="text" data-position="top right" placeholder="DD-MM-YYYY" value="{{old('ola_date')}}" name="ola_date">
                        @if ($errors->has('ola_date'))
                        <div class="text-danger">{{ $errors->first('ola_date') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label>Joining Date*</label>
                        <input class="datepicker-here form-control {{ $errors->has('ola_join_date') ? ' has-error' : ''}}" readonly type="text" data-position="top right" placeholder="DD-MM-YYYY" value="{{old('ola_join_date')}}" name="ola_join_date">
                        @if ($errors->has('ola_join_date'))
                        <div class="text-danger">{{ $errors->first('ola_join_date') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label>Comments</label>
                        <textarea type="text" name="olacomment" value="{{old('olacomment')}}" placeholder="Enter comments if any" class="form-control {{ $errors->has('olacomment') ? ' has-error' : ''}}"></textarea>
                        @if ($errors->has('olacomment'))
                        <div class="text-danger">{{ $errors->first('olacomment') }}</div>
                        @endif
                        <input class="form-control " type="hidden" name="can_id" id="can_id" value="{{$can_data->id}}">
                        <input class="form-control " type="hidden" name="job_id" id="job_id" value="{{$can_data->job_id}}">
                        <input class="form-control " type="hidden" name="id" id="id_joc" value="{{$details->id}}">
                        <input class="form-control " type="hidden" name="process" id="process" value="3">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="text-left"> <button class="btn btn-primary me-3" type="submit"> Add </button></div>
                </div>
            </div>
        </form>
    </div>
</div>


@elseif(is_null($details->appointment_order_received) && $details->offer_ack == 'Yes' )

<!-------------------------------------------------------------------->
<div class="card our-activities">
    <div class="card-body b-b-success">
        <div class="table-responsive">
            <table class="table table-bordernone">
                <tbody>
                    <tr>
                        <td>
                            <div class="media">
                                <div class="icon-wrappar"><i class="fa fa-files-o text-primary"></i></div>
                                <div class="media-body"><a href="#" data-bs-original-title="" title="">
                                        <h5 class="text-dark">Document Verified : <span class="f-18 {{$details->document_verified == 'Yes'?'font-success':'font-danger'}}">{{$details->document_verified}}</span></h5>
                                    </a>
                                    <p>{{substr($details->dv_comment,0,10)}} <a class="example-popover" data-bs-trigger="hover" data-container="body" data-bs-toggle="popover" data-bs-placement="bottom" title="" data-offset="-20px -20px" data-bs-content="{{$details->dv_comment}}" data-bs-original-title="Document Verification" aria-describedby="popover790891">...Read More</a></p>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge badge-light-primary">{{Carbon::parse($details->dv_date)->format('d M Y')}}</span></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="media">
                                <div class="icon-wrappar"><i class="fa fa-check-circle font-secondary"> </i></div>
                                <div class="media-body"><a href="#" data-bs-original-title="" title="">
                                        <h5 class="font-dark">Offer Letter Relesed: <span class="f-18 {{$details->offer_letter == 'Yes'?'font-success':'font-danger'}}">{{$details->offer_letter}}</span></h5>
                                    </a>
                                    <p>{{substr($details->ol_comment,0,10)}} <a class="example-popover" data-bs-trigger="hover" data-container="body" data-bs-toggle="popover" data-bs-placement="bottom" title="" data-offset="-20px -20px" data-bs-content="{{$details->ol_comment}}" data-bs-original-title="Offer Letter Relesed" aria-describedby="popover790891">...Read More</a></p>

                                </div>
                            </div>
                        </td>
                        <td><span class="badge badge-light-secondary">{{Carbon::parse($details->ol_date)->format('d M Y')}}</span></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="media">
                                <div class="icon-wrappar"><i class="fa fa-bookmark font-warning"> </i></div>
                                <div class="media-body"><a href="#" data-bs-original-title="" title="">
                                        <h5 class="font-dark">Offer Acknowledged: <span class="f-18 {{$details->offer_ack == 'Yes'?'font-success':'font-danger'}}">{{$details->offer_ack}}</span></h5>
                                        @if($details->joining_date != NULL )
                                        <h5 class="font-dark">Joining Date: <span class="{{$details->offer_ack == 'Yes'?'font-info':'font-danger'}}">{{Carbon::parse($details->joining_date)->format('d M Y')}}</span></h5>
                                        @endif
                                    </a>
                                    <p>{{substr($details->offer_ack_comment,0,10)}} <a class="example-popover" data-bs-trigger="hover" data-container="body" data-bs-toggle="popover" data-bs-placement="bottom" title="" data-offset="-20px -20px" data-bs-content="{{$details->offer_ack_comment}}" data-bs-original-title="Offer Acknowledged" aria-describedby="popover790891">...Read More</a></p>

                                </div>
                            </div>
                        </td>
                        <td><span class="badge badge-light-warning">{{Carbon::parse($details->offer_ack_date)->format('d M Y')}}</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!--------------------------------------------------------------------------->

<div class="card  b-secondary">
    <div class="card-header b-b-secondary">
        <div class="media">
            <div class="media-body">
                <h5 class="mb-0">Appointment Order Received</h5>
            </div>
        </div>
        <div class="error_schedule mb-2"></div>
        <div class="success_schedule"></div>
    </div>
    <div class="card-body">
        <form action="#" method="#" id="offer_letter" autocomplete="off">
            @csrf
            <div class="row">
                <div class="col-sm-12">
                    <div class="mb-3">
                        <label>Appointment Order Received*</label>
                        <div class="col">
                            <div class="m-t-15 m-checkbox-inline custom-radio-ml">
                                <div class="form-check form-check-inline radio radio-primary">
                                    <input class="form-check-input" id="radioinline1" type="radio" name="aor" value="Yes">
                                    <label class="form-check-label mb-0" for="radioinline1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline radio radio-primary">
                                    <input class="form-check-input" id="radioinline2" type="radio" name="aor" value="No">
                                    <label class="form-check-label mb-0" for="radioinline2">No</label>
                                </div>
                            </div>
                        </div>
                        @if ($errors->has('aor'))
                        <div class="text-danger">{{ $errors->first('aor') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label>PF Form, PAN, Aadhaar Submitted to Admin*</label>
                        <div class="col">
                            <div class="m-t-15 m-checkbox-inline custom-radio-ml">
                                <div class="form-check form-check-inline radio radio-primary">
                                    <input class="form-check-input" id="radioinline3" type="radio" name="document_submitted" value="Yes">
                                    <label class="form-check-label mb-0" for="radioinline3">Yes</label>
                                </div>
                                <div class="form-check form-check-inline radio radio-primary">
                                    <input class="form-check-input" id="radioinline4" type="radio" name="document_submitted" value="No">
                                    <label class="form-check-label mb-0" for="radioinline4">No</label>
                                </div>
                            </div>
                        </div>
                        @if ($errors->has('document_submitted'))
                        <div class="text-danger">{{ $errors->first('document_submitted') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label>Appointment Order Received Date*</label>
                        <input class="datepicker-here form-control {{ $errors->has('aor_date') ? ' has-error' : ''}}" readonly type="text" data-position="top right" placeholder="DD-MM-YYYY" value="{{old('aor_date')}}" name="aor_date">
                        @if ($errors->has('aor_date'))
                        <div class="text-danger">{{ $errors->first('aor_date') }}</div>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label>Comments*</label>
                        <textarea type="text" name="aorcomment" value="{{old('aorcomment')}}" placeholder="Enter comments if any" class="form-control {{ $errors->has('aorcomment') ? ' has-error' : ''}}"></textarea>
                        @if ($errors->has('aorcomment'))
                        <div class="text-danger">{{ $errors->first('aorcomment') }}</div>
                        @endif
                        <input class="form-control " type="hidden" name="can_id" id="can_id" value="{{$can_data->id}}">
                        <input class="form-control " type="hidden" name="job_id" id="job_id" value="{{$can_data->job_id}}">
                        <input class="form-control " type="hidden" name="id" id="id_joc" value="{{$details->id}}">
                        <input class="form-control " type="hidden" name="process" id="process" value="4">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="text-left"> <button class="btn btn-primary me-3" type="submit"> Add </button></div>
                </div>
            </div>
        </form>
    </div>
</div>


@elseif(isset($details->appointment_order_received))


<!-------------------------------------------------------------------->
<div class="card our-activities">
    <div class="card-body b-b-success">
        <div class="table-responsive">
            <table class="table table-bordernone">
                <tbody>
                    <tr>
                        <td>
                            <div class="media">
                                <div class="icon-wrappar"><i class="fa fa-files-o text-primary"></i></div>
                                <div class="media-body"><a href="#" data-bs-original-title="" title="">
                                        <h5 class="text-dark">Document Verified : <span class="f-18 {{$details->document_verified == 'Yes'?'font-success':'font-danger'}}">{{$details->document_verified}}</span></h5>
                                    </a>
                                    <p>{{substr($details->dv_comment,0,10)}} <a class="example-popover" data-bs-trigger="hover" data-container="body" data-bs-toggle="popover" data-bs-placement="bottom" title="" data-offset="-20px -20px" data-bs-content="{{$details->dv_comment}}" data-bs-original-title="Document Verification" aria-describedby="popover790891">...Read More</a></p>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge badge-light-primary">{{Carbon::parse($details->dv_date)->format('d M Y')}}</span></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="media">
                                <div class="icon-wrappar"><i class="fa fa-check-circle font-secondary"> </i></div>
                                <div class="media-body"><a href="#" data-bs-original-title="" title="">
                                        <h5 class="font-dark">Offer Letter Relesed: <span class="f-18 {{$details->offer_letter == 'Yes'?'font-success':'font-danger'}}">{{$details->offer_letter}}</span></h5>
                                    </a>
                                    <p>{{substr($details->ol_comment,0,10)}} <a class="example-popover" data-bs-trigger="hover" data-container="body" data-bs-toggle="popover" data-bs-placement="bottom" title="" data-offset="-20px -20px" data-bs-content="{{$details->ol_comment}}" data-bs-original-title="Offer Letter Relesed" aria-describedby="popover790891">...Read More</a></p>

                                </div>
                            </div>
                        </td>
                        <td><span class="badge badge-light-secondary">{{Carbon::parse($details->ol_date)->format('d M Y')}}</span></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="media">
                                <div class="icon-wrappar"><i class="fa fa-bookmark font-warning"> </i></div>
                                <div class="media-body"><a href="#" data-bs-original-title="" title="">
                                        <h5 class="font-dark">Offer Acknowledged: <span class="f-18 {{$details->offer_ack == 'Yes'?'font-success':'font-danger'}}">{{$details->offer_ack}}</span></h5>
                                        <h5 class="font-dark">Joining Date: <span class="{{$details->offer_ack == 'Yes'?'font-info':'font-danger'}}">{{Carbon::parse($details->joining_date)->format('d M Y')}}</span></h5>
                                    </a>
                                    <p>{{substr($details->offer_ack_comment,0,10)}} <a class="example-popover" data-bs-trigger="hover" data-container="body" data-bs-toggle="popover" data-bs-placement="bottom" title="" data-offset="-20px -20px" data-bs-content="{{$details->offer_ack_comment}}" data-bs-original-title="Offer Acknowledged" aria-describedby="popover790891">...Read More</a></p>

                                </div>
                            </div>
                        </td>
                        <td><span class="badge badge-light-warning">{{Carbon::parse($details->offer_ack_date)->format('d M Y')}}</span></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="media">
                                <div class="icon-wrappar"><i class="fa fa-trophy font-success"> </i></div>
                                <div class="media-body"><a href="#" data-bs-original-title="" title="">
                                        <h5 class="font-dark">Appointment Order Received: <span class="f-18 {{$details->appointment_order_received == 'Yes'?'font-success':'font-danger'}}">{{$details->appointment_order_received}}</span></h5>
                                        <h5 class="font-dark">Document Submitted: <span class="{{$details->document_submitted == 'Yes'?'font-success':'font-danger'}}">{{$details->document_submitted}}</span></h5>
                                    </a>
                                    <p>{{substr($details->aor_comment,0,10)}} <a class="example-popover" data-bs-trigger="hover" data-container="body" data-bs-toggle="popover" data-bs-placement="bottom" title="" data-offset="-20px -20px" data-bs-content="{{$details->aor_comment}}" data-bs-original-title="Appointment Order Received" aria-describedby="popover790891">...Read More</a></p>

                                </div>
                            </div>
                        </td>
                        <td><span class="badge badge-light-success">{{Carbon::parse($details->offer_ack_date)->format('d M Y')}}</span></td>
                    </tr>
                </tbody>
            </table>
            <div class="media justify-content-center pt-5">
                @if($details->candetails->emp_id == null)
                <a href="{{url('candidate-to-emp/'.$details->can_id)}}" class="btn btn-primary">Create Employee</a>
                @else
                <a href="{{url('view-employee/'.$details->candetails->emp_id)}}" class="btn btn-info">View Employee</a>
                @endif
            </div>
        </div>
    </div>
</div>

<!--------------------------------------------------------------------------->

@else
<div class="card our-activities">
    <div class="card-body b-b-success">
        <div class="table-responsive">
            <table class="table table-bordernone">
                <tbody>
                    <tr>
                        <td>
                            <div class="media">
                                <div class="icon-wrappar"><i class="fa fa-files-o text-primary"></i></div>
                                <div class="media-body"><a href="#" data-bs-original-title="" title="">
                                        <h5 class="text-dark">Document Verified : <span class="f-18 {{$details->document_verified == 'Yes'?'font-success':'font-danger'}}">{{$details->document_verified}}</span></h5>
                                    </a>
                                    <p>{{substr($details->dv_comment,0,10)}} <a class="example-popover" data-bs-trigger="hover" data-container="body" data-bs-toggle="popover" data-bs-placement="bottom" title="" data-offset="-20px -20px" data-bs-content="{{$details->dv_comment}}" data-bs-original-title="Document Verification" aria-describedby="popover790891">...Read More</a></p>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge badge-light-primary">{{Carbon::parse($details->dv_date)->format('d M Y')}}</span></td>
                    </tr>
                    @if($details->document_verified != 'No' && $details->document_verified != NULL)
                    <tr>
                        <td>
                            <div class="media">
                                <div class="icon-wrappar"><i class="fa fa-check-circle font-secondary"> </i></div>
                                <div class="media-body"><a href="#" data-bs-original-title="" title="">
                                        <h5 class="font-dark">Offer Letter Relesed: <span class="f-18 {{$details->offer_letter == 'Yes'?'font-success':'font-danger'}}">{{$details->offer_letter}}</span></h5>
                                    </a>
                                    <p>{{substr($details->ol_comment,0,10)}} <a class="example-popover" data-bs-trigger="hover" data-container="body" data-bs-toggle="popover" data-bs-placement="bottom" title="" data-offset="-20px -20px" data-bs-content="{{$details->ol_comment}}" data-bs-original-title="Offer Letter Relesed" aria-describedby="popover790891">...Read More</a></p>

                                </div>
                            </div>
                        </td>
                        <td><span class="badge badge-light-secondary">{{Carbon::parse($details->ol_date)->format('d M Y')}}</span></td>
                    </tr>
                    @endif
                    @if($details->offer_letter != 'No' && $details->offer_letter != NULL)
                    <tr>
                        <td>
                            <div class="media">
                                <div class="icon-wrappar"><i class="fa fa-bookmark font-warning"> </i></div>
                                <div class="media-body"><a href="#" data-bs-original-title="" title="">
                                        <h5 class="font-dark">Offer Acknowledged: <span class="f-18 {{$details->offer_ack == 'Yes'?'font-success':'font-danger'}}">{{$details->offer_ack}}</span></h5>
                                        @if($details->joining_date != NULL)
                                        <h5 class="font-dark">Joining Date: <span class="{{$details->offer_ack == 'Yes'?'font-info':'font-danger'}}">{{Carbon::parse($details->joining_date)->format('d M Y')}}</span></h5>
                                        @endif
                                    </a>
                                    <p>{{substr($details->offer_ack_comment,0,10)}} <a class="example-popover" data-bs-trigger="hover" data-container="body" data-bs-toggle="popover" data-bs-placement="bottom" title="" data-offset="-20px -20px" data-bs-content="{{$details->offer_ack_comment}}" data-bs-original-title="Offer Acknowledged" aria-describedby="popover790891">...Read More</a></p>

                                </div>
                            </div>
                        </td>
                        <td><span class="badge badge-light-warning">{{Carbon::parse($details->offer_ack_date)->format('d M Y')}}</span></td>
                    </tr>
                    @endif
                    @if($details->offer_ack != 'No' && $details->offer_ack != NULL)
                    <tr>
                        <td>
                            <div class="media">
                                <div class="icon-wrappar"><i class="fa fa-trophy font-success"> </i></div>
                                <div class="media-body"><a href="#" data-bs-original-title="" title="">
                                        <h5 class="font-dark">Appointment Order Received1: <span class="f-18 {{$details->appointment_order_received == 'Yes'?'font-success':'font-danger'}}">{{$details->appointment_order_received}}</span></h5>
                                        <h5 class="font-dark">Document Submitted: <span class="{{$details->document_submitted == 'Yes'?'font-success':'font-danger'}}">{{$details->document_submitted}}</span></h5>
                                    </a>
                                    <p>{{substr($details->aor_comment,0,10)}} <a class="example-popover" data-bs-trigger="hover" data-container="body" data-bs-toggle="popover" data-bs-placement="bottom" title="" data-offset="-20px -20px" data-bs-content="{{$details->aor_comment}}" data-bs-original-title="Appointment Order Received" aria-describedby="popover790891">...Read More</a></p>

                                </div>
                            </div>
                        </td>
                        <td><span class="badge badge-light-success">{{Carbon::parse($details->offer_ack_date)->format('d M Y')}}</span></td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@endif


@else
<div class="card  b-secondary">
    <div class="card-header b-b-secondary">
        <div class="media">
            <div class="media-body">
                <h5 class="mb-0">Document Verification</h5>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="error_schedule mb-2"></div>
        <div class="success_schedule"></div>
        <form action="#" method="#" id="document_verification" autocomplete="off">
            @csrf
            <div class="row">
                <div class="col-sm-12">
                    <div class="mb-3">
                        <label>Document Verified*</label>
                        <div class="col">
                            <div class="m-t-15 m-checkbox-inline custom-radio-ml">
                                <div class="form-check form-check-inline radio radio-primary">
                                    <input class="form-check-input" id="radioinline1" type="radio" name="dvr" value="Yes">
                                    <label class="form-check-label mb-0" for="radioinline1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline radio radio-primary">
                                    <input class="form-check-input" id="radioinline2" type="radio" name="dvr" value="No">
                                    <label class="form-check-label mb-0" for="radioinline2">No</label>
                                </div>
                            </div>
                        </div>
                        @if ($errors->has('dvr'))
                        <div class="text-danger">{{ $errors->first('dvr') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label>Verified Date*</label>
                        <input class="datepicker-here form-control {{ $errors->has('dv_date') ? ' has-error' : ''}}" readonly type="text" data-position="top right" placeholder="DD-MM-YYYY" value="{{old('dv_date')}}" name="dv_date">
                        @if ($errors->has('dv_date'))
                        <div class="text-danger">{{ $errors->first('dv_date') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label>Comments*</label>
                        <textarea type="text" name="dvcomment" value="{{old('dvcomment')}}" placeholder="Enter comments if any" class="form-control {{ $errors->has('dvcomment') ? ' has-error' : ''}}"></textarea>
                        @if ($errors->has('dvcomment'))
                        <div class="text-danger">{{ $errors->first('dvcomment') }}</div>
                        @endif

                        <input class="form-control " type="hidden" name="can_id" id="can_id" value="{{$can_data->id}}">
                        <input class="form-control " type="hidden" name="job_id" id="job_id" value="{{$can_data->job_id}}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="text-left"> <button class="btn btn-primary me-3" type="submit"> Add </button></div>
                </div>
            </div>
        </form>
    </div>
</div>



@endif

<script src="{{ asset('assets/js/datepicker/date-picker/datepicker.js') }}"></script>
<script src="{{ asset('assets/js/datepicker/date-picker/datepicker.en.js') }}"></script>
<script src="{{ asset('assets/js/datepicker/date-picker/datepicker.custom.js') }}"></script>


<script>
    $('#document_verification').on('submit', function(event) {
        event.preventDefault();
        var id = $('#can_id').val();
        var job = $('#job_id').val();


        $.ajax({
            url: '{{url("job-offer")}}',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            beforeSend: function() {
                $('#schedule_submit').attr('disabled', 'disabled');
                $('#cancel').attr('disabled', 'disabled');
            },
            success: function(data) {
                var details = '<div class="alert alert-success dark alert-dismissible fade show" role="alert">' + data.success + ' <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button></div>'
                $('.success_schedule').html(details);
                getcandetails(id, job);
                $(":submit").removeAttr("disabled");
                $('#cancel').removeAttr("disabled");
                $('#schedule_modal').modal('hide');
            },

            error: function(data) {
                let error = data["responseJSON"]["errors"];
                let error2 = data["responseJSON"]["message"];
                var error_html = '';
                $.each(error, function(code, message) {
                    error_html += '<p>' + message + '</p>';
                });
                $('.error_schedule').html('<div class="alert alert-danger dark alert-dismissible fade show" role="alert">' + error_html + '<button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button></div>');
                $(":submit").removeAttr("disabled");
                $('#cancel').removeAttr("disabled");
            }
        })
    });
</script>

<script>
    $('#offer_letter').on('submit', function(event) {
        event.preventDefault();

        var can_id = $('#can_id').val();
        var job = $('#job_id').val();
        var id = $('#id_joc').val();
        var ajaxurl = '{{url("job-offer","id")}}';
        ajaxurl = ajaxurl.replace('id', id);

        $.ajax({
            url: ajaxurl,
            method: 'PUT',
            data: $(this).serialize(),
            dataType: 'json',
            beforeSend: function() {
                $('#offer_letter').attr('disabled', 'disabled');
                $('#cancel').attr('disabled', 'disabled');
            },
            success: function(data) {
                var details = '<div class="alert alert-success dark alert-dismissible fade show" role="alert">' + data.success + ' <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button></div>'
                $('.success_schedule').html(details);
                getcandetails(can_id, job);
                $(":submit").removeAttr("disabled");
                $('#cancel').removeAttr("disabled");
                $('#schedule_modal').modal('hide');
            },

            error: function(data) {
                let error = data["responseJSON"]["errors"];
                let error2 = data["responseJSON"]["message"];
                var error_html = '';
                $.each(error, function(code, message) {
                    error_html += '<p>' + message + '</p>';
                });
                $('.error_schedule').html('<div class="alert alert-danger dark alert-dismissible fade show" role="alert">' + error_html + '<button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button></div>');
                $(":submit").removeAttr("disabled");
                $('#cancel').removeAttr("disabled");
            }
        })
    });
</script>
<script src="{{asset('assets/js/popover-custom.js')}}"></script>