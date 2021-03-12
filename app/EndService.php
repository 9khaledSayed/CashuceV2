<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EndService extends Model
{
    protected $guarded = [];

    protected $casts = [
        'termination_date' => 'date: Y-m-d',
    ];

    protected static function booted()
    {

    }

    public function decision(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Decision::class, 'decisionable');
    }
}
