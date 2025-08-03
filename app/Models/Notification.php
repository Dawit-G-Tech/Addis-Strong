<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $primaryKey = 'notification_id';
    public $timestamps = false;

    protected $fillable = ['member_id', 'title', 'message', 'method', 'sent_at'];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
