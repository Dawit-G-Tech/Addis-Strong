<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StaffSchedule extends Model
{
    use HasFactory;

    protected $table = 'staff_schedule';
    protected $primaryKey = 'schedule_id';
    public $timestamps = false;

    protected $fillable = ['staff_id', 'work_date', 'start_time', 'end_time'];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}
