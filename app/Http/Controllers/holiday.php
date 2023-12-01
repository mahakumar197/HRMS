<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\holidaymodel;
use Carbon\Carbon;

class holiday extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $next_year = holidaymodel::whereYear('holidaydate', '=', Carbon::now()->addYear(1)->year)->get();
        return view('superadmin.holiday.index', compact('next_year'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('superadmin.holiday.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validate = $request->validate(
            [

                'holidaydate'   => 'required | unique:holidaymodels',
                'holidayname'   => 'required | alpha_spaces |unique:holidaymodels,holidaydate',
                'holidaytype'   => 'required ',
                'holidayscope'  => 'required ',
                'holidaystatus' => 'required ',

            ],
            $message = [
                'holidaydate.unique'        =>  'Holiday already exist in this date.',
                'holidayname.unique'        =>  'Holiday already exist in this name.',
                'holidaydate.required'      =>  'The holiday date field is required.',
                'holidayname.required'      =>  'The holiday name field is required.',
                'holidayname.alpha_spaces'  =>  'The holiday name may contain only letters and spaces.',
                'holidaytype.required'      =>  'The holiday type field is required.',
                'holidayscope.required'     =>  'The holiday scope field is required.',
                'holidaystatus.required'    =>  'The holiday status field is required.',
            ]

        );



        try {
            $holiday = new holidaymodel;

            $holiday->holidaydate = Carbon::parse($request->holidaydate);
            $holiday->holidayname = $request->holidayname;
            $holiday->holidaytype = $request->holidaytype;
            $holiday->holidayscope = $request->holidayscope;
            $holiday->holidaystatus = $request->holidaystatus;

            $holiday->save();
        } catch (\Exception $e) { // It's actually a QueryException but this works too
            if ($e->getCode() == 23000) {
                return redirect()->back()->with('error', 'Holiday already exist in this date.');
            }
        }
        return redirect()->route('holiday.index')->with('message', 'Holiday Created Successfully');
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

        $holiday = holidaymodel::find($id);
        return view('superadmin.holiday.edit', compact('holiday'));
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

        $validate = $request->validate(
            [

                'holidaydate'   => 'required | unique:holidaymodels',
                'holidayname'   => 'required | alpha_spaces',
                'holidaytype'   => 'required ',
                'holidayscope'  => 'required ',
                'holidaystatus' => 'required ',

            ],
            $message = [
                'holidaydate.unique'         =>  'Holiday already exist in this date.',
                'holidaydate.required'       =>  'The holiday date field is required.',
                'holidayname.required'       =>  'The holiday name field is required.',
                'holidaytype.required'       =>  'The holiday type field is required.',
                'holidayscope.required'      =>  'The holiday scope field is required.',
                'holidaystatus.required'     =>  'The holiday status field is required.',
            ]

        );
        $holiday = holidaymodel::find($id);


        $holiday->holidaydate = Carbon::parse($request->holidaydate);
        $holiday->holidayname = $request->holidayname;
        $holiday->holidaytype = $request->holidaytype;
        $holiday->holidayscope = $request->holidayscope;
        $holiday->holidaystatus = $request->holidaystatus;




        $holiday->update();

        return redirect()->route('holiday.index')->with('message', 'Holiday Updated Successfully.');
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
