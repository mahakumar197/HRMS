<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Job;
use App\Models\JobInterview;
use App\Models\JobOffer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_shorlisted_index($id)
    {
        
        $job = Job::with(['project' => function ($pro) {
            $pro->select('id', 'project_name');
        }, 'position' => function ($pos) {
            $pos->select('id', 'position_name');
        }])->where('id', $id)->select('job_code', 'position_id', 'project_id', 'job_status', 'location', 'job_owner', 'job_posted_date', 'headcount')->first();

        $doc_verified = JobOffer::where('job_id',$id)->where('document_verified', '=', 'Yes')->select('can_id')->get();
        $offer_relesed = JobOffer::where('job_id',$id)->where('offer_letter', '=', 'Yes')->select('can_id')->get();
        $offer_ack = JobOffer::where('job_id',$id)->where('offer_ack', '=', 'Yes')->select('can_id')->get();
        $aor = JobOffer::where('job_id',$id)->where('appointment_order_received', '=', 'Yes')->select('can_id')->get();

        $job_result = JobInterview::where('job_id', $id)->get();
        /*$selected_count = 0;
        foreach ($job_result as $jr) {

            $result = [];
            $result_status = [];
            for ($i = 1; $i <= 10; $i++) {
                $round = 'round_' . $i;
                $round_status = 'round_' . $i . '_status';
                if ($jr->$round != null) {
                    $result[] = $jr->$round;
                }
                if ($jr->$round_status != null && $jr->$round_status == 2) {
                    $result_status[] = $jr->$round_status;
                }
            }
            if (count($result) == count($result_status)) {
                ++$selected_count;
            }
        }*/

        $recruited = JobOffer::where('job_id', $id)->where('appointment_order_received', '=', 'Yes')->count();
        $remaining_count = $job->headcount - $recruited;

        return view('hr.job_offer.index', compact('id', 'job', 'doc_verified', 'offer_relesed', 'offer_ack', 'aor', 'remaining_count'));
    }

    public function shortlisted_candidate(Request $request)
    {

        $job_result = JobInterview::where('job_id', $request->job_id)->get();
        $selected_count = [];
        foreach ($job_result as $jr) {
            $result = [];
            $result_status = [];

            for ($i = 1; $i <= 10; $i++) {
                $round = 'round_' . $i;
                $round_status = 'round_' . $i . '_status';
                if ($jr->$round != null) {
                    $result[] = $jr->$round;
                }
                if ($jr->$round_status != null && $jr->$round_status == 2) {
                    $result_status[] = $jr->$round_status;
                }
            }
            if (count($result) == count($result_status)) {
                $selected_count[] = $jr->id;
            }
        }

        $candidate = JobInterview::whereIn('id', $selected_count)->with(['candetails', 'jobdetails' => function ($j) {
            $j->with('position');
        }])->get();

        return datatables($candidate)->addIndexColumn()

            ->addColumn('action', function ($row) {
                $action = '<a href="#" class="del_ btn btn-xs btn-success btn-edit"  onclick="getcandetails(' . $row->can_id . ',' . $row->job_id . ')">view</a>';
                return   $action;
            })
            ->make(true);
    }



    public function can_offer_details(Request $request)
    {

        $details = JobOffer::with('candetails', 'jobdetails')->where('can_id', $request->id)->where('job_id', $request->job)->first();

        $can_data = Candidate::with([
            'job' => function ($q) {
                $q->with('position');
            }

        ])->where('id', $request->id)->first();
        return view('hr.job_offer.pages.can-offer-details', compact('details', 'can_data'))->render();
    }



    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validate = $request->validate([


            'dvr' => 'required',
            'dv_date' => 'required|date',
            'dvcomment' => 'required'
        ]);


        $dv_data = new JobOffer();
        $dv_data->document_verified = $request->dvr;
        $dv_data->dv_date = Carbon::parse($request->dv_date);
        $dv_data->dv_comment = $request->dvcomment;
        $dv_data->job_id = $request->job_id;
        $dv_data->can_id = $request->can_id;
        $dv_data->dv_update_by = Auth::id();

        $dv_data->save();

        return response()->json(['success' => 'Data saved successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        switch ($request->process) {
            case '2':
                $validate = $request->validate(
                    [
                        'ols' => 'required',
                        'ols_date' => 'required|date',
                        'olscomment' => 'required'
                    ],
                    $message = [
                        'ols.required' => 'Offer letter sent field is required.',
                        'ols_date.required' => 'Sent date field is required.',
                        'ols_date.date' => 'Sent date field must be valid date.',
                        'olscomment' => 'Comment Filed is Required',
                    ]
                );

                $data_update = JobOffer::find($request->id);
                $data_update->offer_letter = $request->ols;
                $data_update->ol_date = Carbon::parse($request->ols_date);
                $data_update->ol_comment = $request->olscomment;
                $data_update->ol_updated_by = Auth::id();
                $data_update->update();
                return response()->json(['success' => 'Offer Letter status successfully.']);


                break;
            case '3':
                $validate = $request->validate(
                    [
                        'ola' => 'required',
                        'ola_date' => 'required|date',
                        'ola_join_date' => 'required_if:ola,Yes|date|nullable',
                        'olacomment' => 'required'
                    ],
                    $message = [
                        'ola.required' => 'Acknowledgement field is required.',
                        'ola_date.required' => 'Acknowledge date field is required.',
                        'ola_date.date' => 'Acknowledge date field must be valid date.',
                        'ola_join_date.required_if' => 'Joining date field is required.',
                        'ola_join_date.date' => 'Joining date field must be valid date.',
                        'olacomment.required' => 'Comment field is required',
                    ]
                );
                $joining_date = $request->ola_join_date != null ? Carbon::parse($request->ola_join_date) : null;

                $data_update = JobOffer::find($request->id);
                $data_update->offer_ack = $request->ola;
                $data_update->offer_ack_date = Carbon::parse($request->ola_date);
                $data_update->joining_date = $joining_date;
                $data_update->offer_ack_comment = $request->olacomment;
                $data_update->ack_updated_by = Auth::id();
                $data_update->update();

                return response()->json(['success' => 'Offer Letter Acknowledgement status successfully.']);
                break;
            case '4':
                $validate = $request->validate(
                    [
                        'aor' => 'required',
                        'aor_date' => 'required|date',
                        'document_submitted' => 'required',
                        'aorcomment' => 'required'
                    ],
                    $message = [
                        'aor.required' => 'Appointment Order field is required.',
                        'aor_date.required' => 'Appointment Order date field is required.',
                        'aor_date.date' => 'Appointment Order date field must be valid date.',
                        'aorcomment.required' => 'Appointment Order date field must be valid date.',
                        'document_submitted.required' => 'PF Form, PAN, Aadhaar Submitted to Admin field required.',
                    ]
                );

                $data_update = JobOffer::find($request->id);
                $data_update->appointment_order_received     = $request->aor;
                $data_update->document_submitted     = $request->document_submitted;
                $data_update->aor_date = Carbon::parse($request->aor_date);
                $data_update->aor_comment = $request->aorcomment;
                $data_update->aor_updated_by = Auth::id();
                $data_update->update();

                return response()->json(['success' => 'Appointment Order Details status successfully.']);

                break;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
