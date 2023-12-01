<?php

namespace App\Http\Controllers\hr;

use App\Http\Controllers\Controller;
use App\Models\Agency;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AgencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('hr.agency.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('hr.agency.create');
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

                "consultancy_name" => "required",
                "contact_person" => "required",
                "contact_number" => "required |digits:10|unique:consultancy",
                "email" => "required|email|unique:consultancy",
                "alternate_email" => "nullable|email|unique:consultancy",
                "start_date" => "required|date",
                "end_date" => "nullable|date | required_if:status,0",
                "status" => "required",

            ],
            $message = [
                "end_date.required_if"    =>    "The end date field is required when status is InActive."
            ]
        );

        $end_date = $request->end_date != null ? Carbon::parse($request->end_date) : null;

        $consultancy = new Agency;

        $consultancy->consultancy_name = $request->consultancy_name;
        $consultancy->contact_person = $request->contact_person;
        $consultancy->contact_number = $request->contact_number;
        $consultancy->email = $request->email;
        $consultancy->alternate_email = $request->alternate_email;
        $consultancy->start_date = Carbon::parse($request->start_date);
        $consultancy->end_date = $end_date;
        $consultancy->status = $request->status;

        $consultancy->password = Hash::make($request->contact_number);

        $consultancy->save();

        return redirect()->route('agency.index')->with('message', 'Consultancy Created Successfully');
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
        $consultancy = Agency::find($id);
        return view('hr.agency.edit', compact('consultancy'));
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

                "consultancy_name" => "required",
                "contact_person" => "required",
                "contact_number" => "required|digits:10|unique:consultancy,contact_number," . $id,
                "email" => "required|email|unique:consultancy,email," . $id,
                "alternate_email" => "nullable|email|unique:consultancy,alternate_email, " . $id,
                "start_date" => "required|date",
                "status" => "required",
                "end_date" => "required_if:status,=,0|date|nullable",
            ],
            $message = [
                'end_date.required_if'      => 'The end date field is required when status is InActive.'
            ]
        );



        $consultancy = Agency::find($id);

        if ($consultancy->password_change_at != Null) {



            $consultancy->consultancy_name = $request->consultancy_name;
            $consultancy->contact_person = $request->contact_person;
            $consultancy->contact_number = $request->contact_number;
            $consultancy->email = $request->email;
            $consultancy->alternate_email = $request->alternate_email;
            $consultancy->start_date = Carbon::parse($request->start_date);
            $consultancy->end_date = $request->end_date != null ? Carbon::parse($request->end_date) : null;
            $consultancy->status = $request->status;

            $consultancy->update();
            return redirect()->route('agency.index')->with('message', 'Consultancy Updated Successfully');
        }
        else{
            return back()->with('error2','The Consultancy has not logged in yet!');
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
