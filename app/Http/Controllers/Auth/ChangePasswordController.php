<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;


class ChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('auth.changePassword');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' =>
            [
                'required',
                'min:8',             // must be at least 10 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],
            'new_confirm_password' => ['same:new_password'],
        ],
        $message=[
            'new_password.regex'            =>  'Your password must contain 1 Upper case, 1 lower case, 1 number, 1 special character',
            'new_password.min'              =>  'The new password must be at least 8 characters',
            'new_confirm_password.same'     =>  'New Password and Confirm New Password should be same',
        ]
    );

        User::find(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password),
            'password_change_at' => Carbon::now(),
        ]);




        return redirect()->back()->with('message2', ' Your Password Updated Successfully! ');
    }
}
