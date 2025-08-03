<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends Model
{
    use HasFactory;

    protected $primaryKey = 'staff_id';
    public $timestamps = false;

    protected $fillable = ['staff_id', 'hire_date', 'salary'];

    public function user()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function schedules()
    {
        return $this->hasMany(StaffSchedule::class, 'staff_id');
    }
}
