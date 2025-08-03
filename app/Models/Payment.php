<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $primaryKey = 'payment_id';
    public $timestamps = false;

    protected $fillable = [
        'member_id', 'amount', 'payment_method',
        'payment_date', 'start_date', 'end_date'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
