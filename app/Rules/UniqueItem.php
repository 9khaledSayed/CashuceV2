<?php

namespace App\Rules;

use App\Allowance;
use App\Company;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Model;

class UniqueItem implements Rule
{
    public $id;
    public $model;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Model $model, $id)
    {
        $this->id = $id;
        $this->model = $model;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if(isset($this->id)) return true; // for update method

        return $this->model->where([
            [$attribute,'=', $value],
            ['company_id', '=', Company::companyID()]
        ])->doesntExist();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.unique_item');
    }
}
