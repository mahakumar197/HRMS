<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Models\InterviewRound;
use Illuminate\Http\Request;
use App\Models\JobPosition;
use App\Models\InterviewTemplateModel;
use Validator;
use Illuminate\Support\Arr;


class InterviewTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('hr.interview_template.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $int_round = InterviewRound::all();
        $position_templated = InterviewTemplateModel::select('position_id')->get();
        $position = JobPosition::whereNotin('id', $position_templated)->where('status', '=', '1')->get();


        return view('hr.interview_template.create', compact('position','int_round'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //  dd($request);

        if ($request->ajax()) {


            $rules = array(
                'round.*'  => 'required',

            );
            $error = Validator::make($request->all(), $rules);
            if ($error->fails()) {
                return response()->json([
                    'error'  => $error->errors()->all()
                ]);
            }


            /*  $int = new InterviewTemplateModel();

      $int->position_id = $request->position_id;
      $int->round_1 = $request->round_1;

      $int->save();
          
        $first_name = $request->round;
       
      for($count = 0; $count < count($first_name); $count++)
      {        
        //'round_'.$count => $first_name[$count],
         
        $data = array(
        $count => $first_name[$count],
        
       );       
     
     $insert_data[] = $data; 


      }

      //  dd($insert_data[1]);*/

            //dd($request->all());

            InterviewTemplateModel::create($request->all());
            return response()->json([
                'success'  => 'Data Added successfully.'
            ]);
        }
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

        $int_round = InterviewTemplateModel::with('position')->find($id);
        return view('hr.interview_template.edit', compact('int_round'));
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

        $int_temp =  InterviewTemplateModel::find($id);

        $int_temp->update($request->all());
        return response()->json([
            'success'  => 'Data Added successfully.'
        ]);
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
