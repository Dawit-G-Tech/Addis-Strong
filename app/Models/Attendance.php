<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $primaryKey = 'attendance_id';
    public $timestamps = false;

    protected $fillable = ['member_id', 'check_in', 'check_out', 'method'];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
