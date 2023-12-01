<?php

namespace App\Http\Controllers\reports;

use App\Http\Controllers\Controller;
use App\Models\TeamAllocations;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TeamSummary extends Controller
{
    public function teamall(Request $request)
    {


        if (request()->ajax()) {


            if ($request->team_from_date != '' && $request->team_to_date != '') {

                $from_date = Carbon::parse($request->team_from_date);
                $to_date = Carbon::parse($request->team_to_date);

                $data = TeamAllocations::with('user.designation')->with('project')->whereDate('start_date', '>=', $from_date)
                    ->whereDate('start_date', '<=', $to_date)->whereDate('end_date', '>=', $from_date)->orWhereBetween('start_date', [$from_date, $to_date])->orWhereBetween('end_date', [$from_date, $to_date]);

                /*$data =  TeamAllocations::with('user.designation')->with('project')
                ->whereBetween('start_date',[$from_date, $to_date])
                ->orWhereBetween('end_date',[$from_date, $to_date])
                ->orWhere(function($q) use($from_date, $to_date){
                        $q->where('end_date','>=',$to_date)->where('start_date','<=',$from_date);
                });*/

                return DataTables::eloquent($data)
                    ->addColumn('name', function ($row) {
                        $first_name = $row->user->name;
                        $last_name = $row->user->last_name;
                        $name = $first_name . ' ' . $last_name;
                        return $name;
                    })
                    ->make(true);
            }
        }
        return view('report.team-summary.superadmin-team');
    }
}
