<?php

namespace App\Rules;

use App\EmployeeViolation;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class NotRepeated implements Rule
{
    private $violationID;
    private $violationDate;

    /**
     * Create a new rule instance.
     *
     * @param Request $request
     * @param null $employeeViolation
     */
    public function __construct($violationID, $violationDate)
    {
        $this->violationID = $violationID;
        $this->violationDate = $violationDate;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $employeeID)
    {
        return $violationQuery = EmployeeViolation::where([
            ['employee_id' ,'=', $employeeID],
            ['date', '=', $this->violationDate],
            ['violation_id', '=', $this->violationID]])->doesntExist();

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.exist_infraction');
    }
}
