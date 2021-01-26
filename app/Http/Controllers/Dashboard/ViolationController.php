<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Violation;
use Illuminate\Http\Request;

class ViolationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee,company,provider');
    }

    public function index(Request $request)
    {
        $this->authorize('view_violations');
        if ($request->ajax()){
            $violations = Violation::get()->map(function ($violation){
                return [
                    'id' => $violation->id,
                    'reason' => app()->isLocale('ar')?$violation->reason_in_arabic:$violation->reason_in_english,
                    'panel1' => __($violation->panel1),
                    'panel2' => __($violation->panel2),
                    'panel3' => __($violation->panel3),
                    'panel4' => __($violation->panel4),
                    'addition_to' => __($violation->addition_to),
                ];
            });
            return response()->json($violations);
        }
        return view('dashboard.violations.index');
    }

    public function create()
    {
        $this->authorize('create_violations');
        return view('dashboard.violations.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create_violations');
        $rules = Violation::$rules;
        Violation::create($request->validate($rules));
        return redirect(route('dashboard.violations.index'));
    }

    public function edit(Violation $violation)
    {
        $this->authorize('update_violations');
        return view('dashboard.violations.edit', compact('violation'));
    }

    public function update(Violation $violation, Request $request)
    {
        $this->authorize('update_violations');
        $rules = Violation::$rules;
        $rules['reason_in_arabic'] = ($rules['reason_in_arabic'] . ',reason_in_arabic,' . $violation->id);
        $rules['reason_in_english'] = ($rules['reason_in_english'] . ',reason_in_english,' . $violation->id);
        $violation->update($request->validate($rules));
        return redirect(route('dashboard.violations.index'));
    }

    public function destroy(Violation $violation, Request $request)
    {
        $this->authorize('delete_violations');
        if($request->ajax()){
            $violation->delete();
            return response()->json([
                'status' => true,
                'message' => 'Item Deleted Successfully'
            ]);
        }
        return redirect(route('dashboard.violations.index'));
    }

    public function additions(Violation $violation)
    {
        return response()->json(['additions' => $violation->addition_to]);
    }
}
