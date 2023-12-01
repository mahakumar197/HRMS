<?php

namespace App\Http\Controllers;

use App\Mail\AnnoncementMail;
use Illuminate\Http\Request;
use App\Models\likes_comments;
use App\Models\AnnouncementModel;
use Illuminate\Support\Facades\Mail;

class announcement extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('superadmin.announcement.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('superadmin.announcement.create');
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

            'title' => 'required',
            'description' => 'required ',
            'status' => 'required'
        ]);

        $announcement = new AnnouncementModel;

        $announcement->title = $request->title;
        $announcement->description = $request->description;
        $announcement->status = $request->status;
        $announcement->save();

        $ann_id = AnnouncementModel::where('title', '=', $request->title)->select('id')->first();

        $details = ([
            'title' => $request->title,
            'id' => $ann_id->id



        ]);

        Mail::to('swordstaff@swordgroup.in')->send(new AnnoncementMail($details));

        return redirect()->route('announcement.index')->with('message', 'Announcement Created Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $announcement = AnnouncementModel::find($id);
        $announce = AnnouncementModel::select('id', 'title', 'created_at', 'description')->orderBy('created_at', 'desc')->where('status', '=', '1')->take(5)->get();
        return view('superadmin.announcement.announcement_show', compact('announcement', 'announce'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $announcement = AnnouncementModel::find($id);
        return view('superadmin.announcement.edit', compact('announcement'));
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

            'title'         => 'required',
            'description'   => 'required ',
            'status'        => 'required'
        ]);
        $announcement = AnnouncementModel::find($id);



        $announcement->title = $request->title;
        $announcement->description = $request->description;
        $announcement->status = $request->status;

        $announcement->update();

        return redirect()->route('announcement.index')->with('message', 'Announcement Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $announcement = AnnouncementModel::find($id);
        $announcement->delete();
        return redirect()->route('announcement.index')->with('message', 'Announcement Deleted successfully');
    }

    public function imgupload(Request $request)
    {

        $mainImage = $request->file('file');
        $filename = time() . '.' . $mainImage->extension();
        // Image::make($mainImage)->save(public_path('tinymce_images/'.$filename));
        $mainImage->move(public_path('tinymce_images'), $filename);


        return json_encode(['location' => '/tinymce_images/' . $filename]);
    }
public function likeAnnouncement(Request $request, $announcement_id, $user_id)
{
    dd($request);
    $user = auth()->user();

    $likeComment = likes_comments::firstOrNew([
        'user_id' => $user->id,
        'announcement_id' => $announcement_id,
    ]);

    $likeComment->like = true;
    $likeComment->save();

    return redirect()->back();
}
public function commentAnnouncement(Request $request, Announcement $announcement)
{
    $user = auth()->user();

    $likeComment = new likes_comments([
        'user_id' => $user->id,
        'announcement_id' => $announcement->id,
        'comments' => $request->input('comments'),
    ]);

    $likeComment->save();

    return redirect()->back();
}
}
