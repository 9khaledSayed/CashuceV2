<?php

namespace App\Http\Controllers\Dashboard;

use App\Conversation;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $this->authorize('view_reports');
        if ($request->ajax()){
            $reports = Report::with(['employee', 'supervisor'])->get();
            return response()->json($reports);
        }
        return view('dashboard.reports.index');
    }


    public function create()
    {
        $this->authorize('create_reports');
        $user = auth()->user();
        $employees = auth()->guard('company') ? $user->employees : $user->supervisedEmployees;
        return view('dashboard.reports.create', compact('employees'));
    }


    public function store(Request $request)
    {
        $this->authorize('create_reports');
        Report::create($request->validate(Report::$rules));
        // TODO:: Notify Hr about this report
        return redirect(route('dashboard.reports.index'));

    }


    public function show(Report $report)
    {
        //
    }


    public function edit(Report $report)
    {
        $this->authorize('update_reports');
        $user = auth()->user();
        $employees = auth()->guard('company') ? $user->employees : $user->supervisedEmployees;
        return view('dashboard.reports.edit', compact('employees', 'report'));
    }


    public function update(Request $request, Report $report)
    {
        $this->authorize('update_reports');
        $report->update($request->validate(Report::$rules));
        return redirect(route('dashboard.reports.index'));
    }


    public function destroy(Request $request,Report $report)
    {
        $this->authorize('delete_reports');
        if($request->ajax()){
            $report->delete();
            return response()->json([
                'status' => true,
                'message' => 'Item Deleted Successfully'
            ]);
        }
        return redirect(route('dashboard.reports.index'));
    }

    public function forwardToEmployee(Report $report)
    {
        $senderId = auth()->user()->id;
        $conversation =  Conversation::firstOrCreate([
            'employee_id' => $report->employee_id,
            'hr_id' => auth()->user()->id,
        ]);
        $content = "<h4>" . __('You have a report from : ')
            .  $report->supervisor->name()
            . " ( " .  $report->supervisor->roles->first()->name()
            . " )</h4>"
            . $report->description;
        $conversation->newMessage($senderId, $report->employee_id, $content);
        return redirect(route('dashboard.conversations.show', $conversation));
    }
}
