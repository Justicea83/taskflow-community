<?php

namespace App\Models\Core;

/**
 * @property mixed $emp_firstname
 * @property mixed $emp_lastname
 * @property mixed $emp_work_email
 */
class Employee extends CoreModel
{
    protected $table = 'hs_hr_employee';

    protected $primaryKey = 'emp_number';
}
