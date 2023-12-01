<?php

namespace App\Http\Controllers\entitlement;

use App\Http\Controllers\Controller;
use App\Models\LeaveEntitlement;
use Illuminate\Http\Request;

class PrivilegeLeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {

            $employee = LeaveEntitlement::with('user', 'leaveType')->where('leave_type_id', '=', '2')->select('user_id', 'leave_type_id', 'entitlement', 'id')->get();

            return datatables($employee)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {

                    $action = '<a  href=" privilegeleave/' . $row->id . '/edit "><svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" 
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3">
                                <polygon points="14 2 18 6 7 17 3 17 3 13 14 2"></polygon> <line x1="3" y1="22" x2="21" y2="22"></line></svg></a>';
                    return $action;
                })
                ->rawColumns(['action'])
                ->addColumn('name', function ($row) {
                    $first_name = $row->user->name;
                    $last_name = $row->user->last_name;
                    $name = $first_name . ' ' . $last_name;
                    return $name;
                })

                ->make(true);
        }
        return view('entitlement.privilegeleave.index');
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
        //
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
        $employee = LeaveEntitlement::with('user', 'leaveType')->find($id);
        return view('entitlement.privilegeleave.edit', compact('employee'));
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
        $validate = $request->validate([

            'entitlement' => 'required|numeric'
        ]);


        // dd($request);
        $entitlement = LeaveEntitlement::find($id);

        $entitlement->entitlement = $request->entitlement;

        $entitlement->update();

        return redirect()->route('privilegeleave.index')->with('message', 'Entitlement Updated Successfully.');
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
