<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\LeaveBalance;
use Illuminate\Http\Request;

class LeaveBalanceController extends Controller
{
    public function index()
    {
        $leaveBalances = LeaveBalance::paginate(4);
        return view('dashboard.settings.leave_balances.index', compact('leaveBalances'));
    }


    public function create()
    {
        return view('dashboard.settings.leave_balances.create');
    }

    public function store(Request $request)
    {
        LeaveBalance::create($this->validator($request));
        return redirect(route('dashboard.leave_balances.index'));
    }

    public function edit(LeaveBalance $leaveBalance)
    {
        return view('dashboard.settings.leave_balances.edit', compact('leaveBalance'));
    }


    public function update(Request $request, LeaveBalance $leaveBalance)
    {
        $leaveBalance->update($this->validator($request, $leaveBalance->id));
        return redirect(route('dashboard.leave_balances.index'));
    }


    public function destroy(LeaveBalance $leaveBalance)
    {
        //
    }

    public function validator(Request $request, $id = null)
    {
        $rules = LeaveBalance::$rules;
        return $request->validate($rules);
    }
}
