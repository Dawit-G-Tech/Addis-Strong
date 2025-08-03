<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrainingSession extends Model
{
    use HasFactory;

    protected $primaryKey = 'session_id';
    public $timestamps = false;

    protected $fillable = ['member_id', 'trainer_id', 'session_time', 'status', 'notes'];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }
}
