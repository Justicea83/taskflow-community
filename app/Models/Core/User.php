<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property mixed $password
 * @property mixed $email
 * @property mixed $first_name
 * @property mixed $last_name
 */
class User extends CoreModel
{
    protected $table = 'core_user';

    public function employee(): HasOne
    {
        return $this->hasOne(Employee::class, 'emp_number', 'id');
    }
}