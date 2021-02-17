<?php

namespace App;

use App\Scopes\CompletedScope;
use App\Scopes\ParentScope;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    public static $rules = [
        'name_en' => ['required', 'string', 'max:191'],
        'nationality_id'  => 'required|max:255|exists:nationalities,id',
        'department_id'  => 'nullable|max:255|exists:departments,id',
        'job_title_id'  => 'nullable|exists:job_titles,id',
        'section_id'  => 'nullable|max:255|exists:sections,id',
        'residence_profession' => 'required|string|max:255',
        'enterprise' => 'nullable|string|max:255',
        'id_num' => 'required|numeric|',
        'skills' => 'nullable|array',
        'birthdate' => 'required|date',
        'interview_date' => 'required|date',
        'training_start_date' => 'nullable|date',
    ];

    protected $casts = [
        'interview_date' => 'date',
        'training_start_date' => 'date:Y-m-d',
        'created_at' => 'date'
    ];

    protected $guarded = [];

    public static function booted()
    {
        static::addGlobalScope(new ParentScope());

        static::creating(function ($model){
            $model->company_id = Company::companyID();
            $model->provider_id = auth()->guard('provider')->check() ? auth()->user()->id : null;
        });

    }

    public function name()
    {
        return $this->{'name_' . app()->getLocale()};
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }


    public function setSkillsAttribute($skills)
    {
        $this->attributes['skills'] = serialize($skills);
    }

    public function getSkillsAttribute($skills)
    {
         return unserialize($this->attributes['skills']);
    }

    public function getDepartmentNameAttribute()
    {
         return isset($this->department_id) ? Department::find($this->department_id)->name() : __('Not Found');
    }

    public function getSectionNameAttribute()
    {
         return isset($this->section_id) ? Section::find($this->section_id)->name() : __('Not Found');
    }

    public function getNationalityNameAttribute()
    {
         return isset($this->nationality_id) ? Nationality::find($this->nationality_id)->name() : __('Not Found');
    }

    public function getJobTitleAttribute()
    {
         return isset($this->job_title_id) ? JobTitle::find($this->job_title_id)->name() : __('Not Found');
    }


    public function getStatusNameAttribute()
    {
        if($this->status == config('enums.candidate.pending')){
            return __('Pending');
        }elseif ($this->status == config('enums.candidate.training')){
            return __('Training');
        }elseif($this->status == config('enums.candidate.approved')){
            return __('Approved');
        }else{
            return __('Disapproved');
        }
    }

    public function getStatusClassAttribute()
    {
        if($this->status == config('enums.candidate.pending')){
            return 'kt-badge--primary';;
        }elseif ($this->status == config('enums.candidate.training')){
            return 'kt-badge--warning';
        }elseif($this->status == config('enums.candidate.approved')){
            return 'kt-badge--success';
        }else{
            return 'kt-badge--danger';
        }
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

}
