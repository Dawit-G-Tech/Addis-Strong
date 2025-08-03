<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use HasFactory;

    protected $primaryKey = 'member_id';
    public $timestamps = false;

    protected $fillable = ['member_id', 'membership_id', 'weight', 'height'];

    public function user()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    public function membership()
    {
        return $this->belongsTo(Membership::class, 'membership_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'member_id');
    }

    public function bookings()
    {
        return $this->hasMany(ClassBooking::class, 'member_id');
    }

    public function trainingSessions()
    {
        return $this->hasMany(TrainingSession::class, 'member_id');
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'member_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'member_id');
    }

    public function accessControls()
    {
        return $this->hasMany(AccessControl::class, 'member_id');
    }
}
