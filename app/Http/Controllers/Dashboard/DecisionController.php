<?php

namespace App\Http\Controllers\Dashboard;

use App\Decision;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DecisionController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()){
            $decisions = Decision::get()->map(function ($decision){
                return [
                    'id' => $decision->id,
                    'type' => $decision->decisionable_type,
                    'employee_name' => $decision->employee->name(),
                    'employee_id' => $decision->employee->id,
                    'created_at' => $decision->created_at->format('Y-m-d'),
                ];
            });

            return response()->json($decisions);
        }
        return view('dashboard.decisions.index');
    }



    public function show(Decision $decision)
    {
        if ($decision->decisionable_type == 'App\\EndService'){
            return redirect(route('dashboard.decisions.end_services.show', $decision->decisionable_id));
        }
    }



    public function destroy(Decision $decision)
    {
        //
    }
}
