<?php

namespace App\Http\Controllers\Dashboard;

use App\JobTitle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JobTitleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee,company,provider');
    }

    public function index(Request $request)
    {
        $this->authorize('view_settings');
        if ($request->ajax()) {
            $job_titles = JobTitle::all();
            return response()->json($job_titles);
        }
        return  view('dashboard.settings.job_titles.index');

    }

    public function create()
    {
        $this->authorize('view_settings');
        return  view('dashboard.settings.job_titles.create');
    }

    public function store(Request $request)
    {
        $this->authorize('view_settings');
        JobTitle::create($this->validator($request));
        return redirect(route('dashboard.job_titles.index'));
    }

    public function edit(JobTitle $job_title)
    {
        $this->authorize('view_settings');
        return  view('dashboard.settings.job_titles.edit',compact('job_title'));
    }

    public function update(Request $request, JobTitle $job_title)
    {
        $this->authorize('view_settings');
        $job_title->update($this->validator($request, $job_title->id));
        return redirect(route('dashboard.job_titles.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\JobTitle  $jobTitle
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobTitle $jobTitle)
    {
        //
    }

    public function validator(Request $request, $id = null)
    {
        $rules = JobTitle::$rules;
        if($id){
            $rules['name_ar'] = ($rules['name_ar'] . ',name_ar,' . $id);
            $rules['name_en'] = ($rules['name_en'] . ',name_en,' . $id);
        }
        return $request->validate($rules);
    }
}
