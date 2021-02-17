<?php

namespace App\Http\Controllers\Dashboard;

use App\Candidate;
use App\Department;
use App\Employee;
use App\Http\Controllers\Controller;
use App\JobTitle;
use App\Nationality;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    protected $skills = [
        'Arabic',
        'English',
        'Computer Usage',
    ];




    public function index(Request $request)
    {
//        $this->authorize('view_users');

        if ($request->ajax()){
            $candidates = Candidate::get();

            if(isset($request->req_parameter)){
                if ($request->req_parameter == 'departments_candidates'){
                    $candidates = $candidates->whereNotNull('department_id');
                }else{
                    $candidates = $candidates->where('status', config('config.enum.candidate.training'));
                }
            }

            $candidates = $candidates->map(function ($candidate){
                $provider = isset($candidate->provider) ? $candidate->provider->name() : __('Not Found');
                return [
                    'id' => $candidate->id,
                    'name' => $candidate->name(),
                    'provider' => $provider,
                    'interview_date' => $candidate->interview_date->format('Y-m-d'),
                    'status_name' => $candidate->status_name,
                    'status_class' => $candidate->status_class,
                    'department' => $candidate->department_name,
                    'created_at' => $candidate->created_at->format('Y-m-d'),
                ];
            });
            return response()->json($candidates);
        }
        return view('dashboard.candidates.index');
    }

    public function create()
    {
//        $this->authorize('create_users');
        return view('dashboard.candidates.create', [
            'skills' => $this->skills,
            'departments' => Department::all(),
            'jobTitles' => JobTitle::all(),
            'nationalities' => Nationality::all(),
        ]);
    }

    public function store(Request $request)
    {
//        $this->authorize('create_users');
        $candidate = Candidate::create($this->validator($request));
        return response()->json([
            'id' => $candidate->id
        ]);

//        return redirect(route('dashboard.candidates.index'));
    }

    public function edit(Candidate $candidate)
    {
//        $this->authorize('update_users');
        return view('dashboard.candidates.edit', [
            'candidate' => $candidate,
            'skills' => $this->skills,
            'departments' => Department::all(),
            'jobTitles' => JobTitle::all(),
            'nationalities' => Nationality::all(),
        ]);
    }

    public function update(Candidate $candidate, Request $request)
    {
//        $this->authorize('update_users');
        $candidate->update($this->validator($request, $candidate->id));
        return response()->json([
            'id' => $candidate->id
        ]);
//        return redirect(route('dashboard.candidates.index'));
    }

    public function show(Candidate $candidate)
    {
        return view('dashboard.candidates.show', compact('candidate'));
    }

    public function destroy(Candidate $candidate, Request $request)
    {
//        $this->authorize('delete_users');
        if($request->ajax()){
            $candidate->delete();
            return response()->json([
                'status' => true,
                'message' => 'Item Deleted Successfully'
            ]);
        }
        return redirect(route('dashboard.candidates.index'));
    }

    public function decision(Candidate $candidate, Request $request)
    {
        $candidate->update($request->validate([
            'status' => 'required|numeric',
            'comments' => 'nullable',
        ]));

        if($request->status == config('enums.candidate.approved')){
            $employee = Employee::Create($candidate->only([
                'name_en',
                'nationality_id',
                'department_id',
                'job_title_id',
                'section_id',
                'id_num',
                'birthdate',
            ]));

            $candidate->delete();
            return redirect(route('dashboard.candidates.index'));
        }

        return redirect()->back();
    }

    public function validator(Request $request, $id = null)
    {
        $rules = Candidate::$rules;
        return $request->validate($rules);
    }

    public function uploadDocuments(Request $request, Candidate $candidate)
    {
        $request->validate([
            'file' => 'required|'
        ]);
        $fileName = $request->file('file')->getClientOriginalName();
        $request->file('file')->storeAs('public/documents/', $fileName);

        $candidate->documents()->create([
            'file_name' => $fileName,
        ]);

        return response()->json([
            'status' => 1
        ]);
    }

}
