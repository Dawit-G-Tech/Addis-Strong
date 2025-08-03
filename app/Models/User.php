<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

    protected $primaryKey = 'user_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone',
        'gender', 'dob', 'address', 'registration_date',
        'hashed_password', 'profile_picture', 'role_id', 'status'
    ];

    protected $hidden = ['hashed_password'];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function member()
    {
        return $this->hasOne(Member::class, 'member_id');
    }

    public function staff()
    {
        return $this->hasOne(Staff::class, 'staff_id');
    }
}
