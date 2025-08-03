<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassBooking extends Model
{
    use HasFactory;

    protected $table = 'class_bookings';
    public $timestamps = false;
    public $incrementing = false;

    protected $primaryKey = null;

    protected $fillable = ['member_id', 'class_id', 'status', 'booking_date'];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function classModel()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }
}
