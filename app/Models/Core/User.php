<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property Employee $employee
 * @property mixed $user_password
 * @property mixed $user_name
 */
class User extends CoreModel
{
    protected $table = 'ohrm_user';

    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class, 'emp_number', 'id');
    }
}