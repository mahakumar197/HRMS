<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobPosition as ModelsJobPosition;
use Illuminate\Http\Request;

class JobPosition extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('hr.job_position.index');
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

            'position_name' => 'required|unique:job_positions',
            'status' => 'required'

        ], $message = [
            'position_name.required'    => 'Job Position field is required.',
            'position_name.unique'      => 'Job Position already exists.',
        ]);



        $position = new ModelsJobPosition();
        $position->position_name = $request->position_name;
        $position->status = $request->status;

        $position->save();


        return response()->json(['success' => 'Job Position saved successfully.']);
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

        $job_position = ModelsJobPosition::find($id);
        return view('hr.job_position.edit', compact('job_position'));
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

            'position_name' => 'required|unique:job_positions,position_name,' . $id,
            'status' => 'required'

        ], $message = [
            'position_name.required'    => 'Job Position field is required.',
            'position_name.unique'      => 'Job Position already exists.',
        ]);

        $job = Job::where('position_id', $id)->select('id')->exists();


        if ($job == false) {

            $position = ModelsJobPosition::find($id);
            $position->position_name = $request->position_name;
            $position->status = $request->status;
            $position->update();
            return redirect()->route('job-position.index')->with('message', 'Job Position Updated Successfully.');
        } else {
            return redirect()->route('job-position.index')->with('error', 'Job has been created with this position.');
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
