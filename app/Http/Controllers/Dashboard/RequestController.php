<?php

namespace App\Http\Controllers\Dashboard;

use App\Attendance;
use App\Http\Controllers\Controller;
use App\Notifications\RespondToRequest;
use App\Request;
use Carbon\Carbon;
use Illuminate\Http\Request as HttpRequest;

class RequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee,company,provider');
    }

    public function index(HttpRequest $request)
    {
        $this->authorize('view_requests');
        if ($request->ajax()) {
            $requests = Request::with('employee')->get();
            if(auth()->guard('employee')->check()){

                if (!auth()->user()->isHR()){

                    $requests = $requests->filter(function ($request){
                        if ($request->employee->supervisor_id == auth()->user()->id){
                            return $request;
                        }
                    });

                }

            }

            return response()->json($requests);
        }
        return view('dashboard.requests.index');
    }


    public function pendingRequests(HttpRequest $request)
    {
        $this->authorize('view_requests');
        if ($request->ajax()) {
            $requests = Request::with('employee')->where('status', 0)->get();
            return response()->json($requests);
        }
        return view('dashboard.requests.pending_requests');
    }

    public function myRequests(HttpRequest $request)
    {
        $this->authorize('view_my_requests');
        $this->authorize('must_be_employee');
        if ($request->ajax()) {
            $requests = Request::with('employee')->where('employee_id', auth()->user()->id)->get();
            return response()->json($requests);
        }
        return view('dashboard.requests.my_requests');
    }

    public function create()
    {
        //
    }


    public function store(HttpRequest $request)
    {
        //
    }


    public function show(Request $request)
    {
        $this->authorize('show_requests');
        $employee = $request->employee;
        $requestable = $request->requestable;
        if ($request->requestable_type == 'App\\AttendanceForgotten'){
            return view('dashboard.attendance_forgottens.show', compact('request', 'employee', 'requestable'));
        }else{
            return view('dashboard.vacations.show', compact('request', 'employee', 'requestable'));
        }

    }


    public function edit(Request $request)
    {
        //
    }


    public function update(Request $request, HttpRequest $httpRequest)
    {
        //
    }


    public function destroy(Request $request)
    {
        $this->authorize('delete_requests');
        $request->delete();
        return response()->json([
            'status' => true,
            'message' => 'Item Deleted Successfully'
        ]);
    }

    public function takeAction(HttpRequest $httpRequest,Request $request)
    {
        $this->authorize('proceed_requests');
        $request->update($httpRequest->validate([
            'status' => 'required|numeric|min:1|max:2',
            'comment' => 'nullable|string|max:191',
        ]));

        if ($request->status == 1){
            if($request->requestable_type == 'App\\Vacation'){
                $vacationDays = $request->requestable->total_days;
                $request->employee->leave_balance -= $vacationDays;
                $request->employee->save();
            }else{
                Attendance::firstOrCreate([
                    'employee_id' => $request->employee_id,
                    'time_in' => Carbon::createFromTime(9)->format('H:i'),
                    'date' => $request->requestable->forgotten_date,
                ]);

            }
        }

        $status = $request->status == 1 ? 'Approved': 'Disapproved';
        $request->employee->notify(new RespondToRequest($request->id, $status));
        return redirect(route('dashboard.requests.index'));
    }
}
