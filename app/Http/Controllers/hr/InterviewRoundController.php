<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Models\InterviewRound;
use App\Models\Job;
use Illuminate\Http\Request;

class InterviewRoundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('hr.interview_round.index');
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

        $data = $request->validate([
            'round_name'    =>  'required|unique:interview_rounds',
            'feedback_template' => 'required',
        ]);

        $interview_round = new InterviewRound();
        $interview_round->round_name = $request->round_name;
        $interview_round->feedback_template = $request->feedback_template;
        $interview_round->save();
        return response()->json(['success' => 'Interview Round Saved Successfully.']);
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
        $interview_round = InterviewRound::find($id);
        return view('hr.interview_round.edit', compact('interview_round'));
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
        $data = $request->validate([
            'round_name'    =>  'required|unique:interview_rounds,round_name,' . $id
        ]);
        $job_int = Job::select('rounds')->get();

        foreach ($job_int as $int) {
            if (in_array($id, $int->rounds)) {
                return redirect()->route('interview-round.index')->with('error', 'Interview Round linked with Job cannot be edited.');
            }
        }

        
        $interview_round = InterviewRound::find($id);
        $interview_round->round_name = $request->round_name;

        $interview_round->feedback_template = $request->feedback_template;
        $interview_round->update();
        return redirect()->route('interview-round.index')->with('message', 'Interview Round Updated Successfully.');
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

    public function getInterviewRounds()
    {
        $interview_round = InterviewRound::get();
        return datatables($interview_round)->addIndexColumn()

            ->editColumn('feedback_template', function ($feedback) {



                if ($feedback->feedback_template == 0) return 'Common Template';
                if ($feedback->feedback_template == 1) return 'HR Template ';
                if ($feedback->feedback_template == 2) return 'Tech Template ';
            })
            ->addColumn('action', function ($row) {

                $action = '<a  href=" interview-round/' . $row->id . '/edit ">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3">
                    <polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon>
                      <line x1="3" y1="22" x2="21" y2="22"></line>
                </svg></a>';
                return $action;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
