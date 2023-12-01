<?php

namespace App\Http\Controllers;

use App\Models\feedback;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('feedback.feedback_index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('feedback.feedback_create');
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

            'email' => 'required',
            'feedbackdate' => 'required',
            'hereismy' => 'required',
            'regarding' => 'required',
            'description' => 'required',
        ],
        $message = [
            
             'email.required' => 'The email field is required',
             'feedbackdate.required' => 'The date field is requires',
             'hereismy.required' => 'This field is required',
             'regarding.required' => 'This field is required',
             'description.required' => 'This field is required'

        ],
    
        );

        $id = Auth::user()->id;

        if($request->image != null){
        $image_path = time() . '.' . $request->image->extension();

        $request->image->move(public_path('feedback-image'), $image_path);
        }
         
        
        $feedback = new feedback;

        $feedback->user_id =$id;

        $feedback->email = $request->email;
        $feedback->feedback_date = Carbon::parse($request->feedbackdate); 
        $feedback->hereismy = $request->hereismy;
        $feedback->regarding = $request->regarding;
        $feedback->description = $request->description;
      
        if($request->image != null){
        $feedback->feedback_image = $image_path;
        }

        $feedback->save();
        
        return redirect()->route('feedback.index')->with('message', 'Thank you for submitting Feedback');
       
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $feedback = feedback::find($id);   
         
        return view('feedback.feedback_show',compact('feedback'));
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
        //
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
