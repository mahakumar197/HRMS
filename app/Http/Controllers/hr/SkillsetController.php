<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\SkillSet;
use Illuminate\Http\Request;

class SkillsetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('hr.skillset.index');
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

            'skillset' => 'required|unique:skillsets'

        ], $message = [
            'skillset.required'    => 'Skillset field is required.',
            'skillset.unique'      => 'Skillset already exists.',
        ]);

        $skillset = new SkillSet();
        $skillset->skillset = $request->skillset;
        $skillset->save();
        return response()->json(['success' => 'Skillset saved successfully.']);
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
        $skillset = SkillSet::find($id);
        return view('hr.skillset.edit', compact('skillset'));
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

            'skillset' => 'required|unique:skillsets,skillset,' . $id

        ], $message = [
            'skillset.required'    => 'Skillset field is required.',
            'skillset.unique'      => 'Skillset already exists.',
        ]);

        $job_skills = Job::select('essential_skills', 'desirable_skills')->get();
        foreach ($job_skills as $skills) {
            if (in_array($id, $skills->essential_skills) || in_array($id, $skills->desirable_skills) ) {
                return redirect()->route('skillset.index')->with('error', 'Skill linked with Job cannot be edited.');
            }
        }

        $skillset = SkillSet::find($id);
        $skillset->skillset = $request->skillset;
        $skillset->update();
        return redirect()->route('skillset.index')->with('message', 'Skillset Updated Successfully.');
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

    public function getSkillset()
    {
        $skillset = SkillSet::orderBy('created_at', 'DESC')->get();

        return datatables($skillset)->addIndexColumn()
            ->addColumn('action', function ($row) {

                $action = '<a  href=" skillset/' . $row->id . '/edit "><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3">
            <polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon>
            <line x1="3" y1="22" x2="21" y2="22"></line>
          </svg></a>';
                return $action;
            })
            ->rawColumns(['action'])

            ->make(true);
    }
}
