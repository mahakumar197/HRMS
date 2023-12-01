<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\designation;
use App\Models\User;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {      
       
        return view('superadmin.designation.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('superadmin.designation.create');
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

                   'designation' => 'required|alpha_spaces |unique:designation'
              ],
            $message=[

                'designation.unique'         => 'Designation already exists',
                'designation.alpha_spaces'   => 'Designation can contain only letters and spaces'
            ]
            );
          
            $empy = new designation;    

            $empy->designation = $request->designation;
             
            $empy->save();

        return redirect()->route('designation.index')->with('message','Designation Created Successfully.');
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

        $designation = designation::find($id);
        return view('superadmin.designation.edit', compact('designation'));
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

            'designation' => 'required|alpha_spaces| unique:designation,designation,'.$id,
       ],
       $message=[

        'designation.unique'         => 'Designation already exists.',
        'designation.alpha_spaces'   => 'Designation can contain only letters and spaces.'
    ]
    );
        
        $designation = designation::find($id);
       
        $designationhasemp = User::where('designation_id',$id)->exists();
        
        if($designationhasemp=='true'){
            if($request->designation != $designation->designation){
                return redirect()->back()->with('error','Employee exists with this designation.');
            }
        }

             $designation->designation = $request->designation;
             
             $designation->update();

        return redirect()->route('designation.index')->with('message','Designation Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $designation = designation::find($id);
        $designation->delete();
        return redirect()->route('designation.index')->with('message','Designation Deleted successfully');
    }
}
