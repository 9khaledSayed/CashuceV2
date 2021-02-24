<?php

namespace App\Http\Controllers\Dashboard;

use App\Allowance;
use App\Http\Controllers\Controller;
use App\Rules\PresentedAlone;
use App\Rules\RequiredIfNull;
use App\Rules\UniqueItem;
use Illuminate\Http\Request;

class AllowanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee,company,provider');
    }

    public function index(Request $request)
    {
        $this->authorize('view_settings');
        if ($request->ajax()) {
            $allowanceTypes = Allowance::all();
            return response()->json($allowanceTypes);
        }
        return view('dashboard.settings.allowances.index');
    }

    public function create()
    {
        $this->authorize('view_settings');
        return view('dashboard.settings.allowances.create');
    }


    public function store(Request $request)
    {
        $this->authorize('view_settings');
        Allowance::create($this->validator($request));
        return redirect(route('dashboard.allowances.index'));
    }

    public function edit(Allowance $allowance)
    {
        $this->authorize('view_settings');
        return view('dashboard.settings.allowances.edit',compact('allowance'));
    }

    public function update(Allowance $allowance , Request $request)
    {
        $this->authorize('view_settings');
        $allowance->update($this->validator($request, $allowance->id));
        return redirect(route('dashboard.allowances.index'));
    }


    public function destroy( Request $request , Allowance $allowance)
    {
        $this->authorize('view_settings');
        if($request->ajax() && !$allowance->is_basic){
            $allowance->delete();
            return response()->json([
                'status' => true,
                'message' => 'Item Deleted Successfully'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'message' => 'Can\'t Delete Basic Allowance'
            ]);
        }

    }

    public function validator(Request $request, $id = null)
    {

        $rules = Allowance::$rules;

        array_push($rules['name_ar'], new UniqueItem(new Allowance(), $id));
        array_push($rules['name_en'], new UniqueItem(new Allowance(), $id));
        array_push($rules['percentage'], new PresentedAlone($request->value));
        array_push($rules['value'], new RequiredIfNull($request));

        return $request->validate($rules);
    }
}
