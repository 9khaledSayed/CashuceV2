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
        'Bengali',
        'Urdu',
    ];

    public function __construct()
    {
//        $this->authorize('not-company');
    }


    public function index(Request $request)
    {
//        $this->authorize('view_users');
        $this->authorize('not-company');
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
                    'name' => $candidate->name_en,
                    'nationality' => $candidate->nationality_name,
                    'age' => $candidate->birthdate->diffInYears(\Carbon\Carbon::today()),
                    'iqama_no' => $candidate->id_num,
                    'english' => in_array('English',$candidate->skills),
                    'arabic' => in_array('Arabic',$candidate->skills),
                    'computer' => in_array('Computer Usage',$candidate->skills),
                    'bengali' => in_array('Bengali',$candidate->skills),
                    'urdu' => in_array('Urdu',$candidate->skills),
                    'status_name' => $candidate->status_name,
                    'status_class' => $candidate->status_class,
                    'department' => $candidate->department_name,
                    'is_provider' => auth()->guard('provider')->check(),
                ];
            });
            return response()->json($candidates);
        }
        return view('dashboard.candidates.index', [
            'departments' => Department::all(),
        ]);
    }

    public function create()
    {
//        $this->authorize('create_users');
        $this->authorize('not-company');
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
        $this->authorize('not-company');
        $candidate = Candidate::create($this->validator($request));
        return response()->json([
            'id' => $candidate->id
        ]);

//        return redirect(route('dashboard.candidates.index'));
    }

    public function edit(Candidate $candidate)
    {
//        $this->authorize('update_users');
        $this->authorize('not-company');
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
        $this->authorize('not-company');
        $candidate->update($this->validator($request, $candidate->id));
        return response()->json([
            'id' => $candidate->id
        ]);
//        return redirect(route('dashboard.candidates.index'));
    }

    public function show(Candidate $candidate)
    {
        $this->authorize('not-company');
        return view('dashboard.candidates.show', [
            'departments' => Department::all(),
            'jobTitles' => JobTitle::all(),
            'candidate' => $candidate,
        ]);
    }

    public function destroy(Candidate $candidate, Request $request)
    {
//        $this->authorize('delete_users');
        $this->authorize('not-company');
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
        $this->authorize('not-company');
        $candidate->update($request->validate([
            'status' => 'required|numeric',
            'department_id'  => 'nullable|max:255|exists:departments,id',
            'job_title_id'  => 'nullable|exists:job_titles,id',
            'section_id'  => 'nullable|max:255|exists:sections,id',
            'training_start_date' => 'nullable|date',
        ]));

        if($request->status == config('enums.candidate.approved')) {
            if(auth()->user()->isSupervisor()){
                $candidate->update([
                    'supervisor_approval' => true,
                    'status' => config('enums.candidate.approved'),
                ]);
            }else{
                $candidate->update([
                    'hr_approval' => true,
                    'status' => config('enums.candidate.approved'),
                ]);
            }
            if ($candidate->supervisor_approval && $candidate->hr_approval){
                $candidate->update([
                    'status' => config('enums.candidate.completed'),
                ]);
            }
        }

        if($request->status == 0){
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
//            return redirect(route('dashboard.candidates.index'));
        }

        return response()->json([
            'status' => 1
        ]);
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
