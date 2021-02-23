<?php

namespace App\Http\Controllers\Dashboard;

use App\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use anlutro\LaravelSettings\Facade as Setting;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee,company,provider');
    }

    public function setManagerID()
    {
        Setting::setExtraColumns(array(
            'company_id' => Company::companyID()
        ));
   }



    public function language(Request $request)
    {
        $this->authorize('view_settings');
        $this->setManagerID();

        if ($request->post()){

            setting($request->validate([
                'lang' => 'required',
            ]))->save();

            return redirect(route('dashboard.settings.language'))->with('success', 'true');
        }
        return view('dashboard.settings.language');
    }

    public function payrolls(Request $request)
    {
        $this->authorize('view_settings');
        $this->setManagerID();

        if ($request->post()){

            setting($request->validate([
                'operations' => 'required',
                'payroll_day' => 'required',
                'work_days' => 'required',
            ]))->save();

            return redirect(route('dashboard.settings.payrolls'))->with('success', 'true');
        }
        return view('dashboard.settings.payrolls');
    }


}
