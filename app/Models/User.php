<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'name',
        'email',
        'gender',
        'dob',
        'registration_date',
        'password',
        'profile_picture',
        'role_id',
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'dob' => 'date',
        'registration_date' => 'date',
    ];

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

    /**
     * Get the user's full name.
     */
    public function getNameAttribute($value)
    {
        return $value ?: $this->email;
    }
}
