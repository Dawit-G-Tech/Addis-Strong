<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccessControl extends Model
{
    use HasFactory;

    protected $primaryKey = 'access_id';
    public $timestamps = false;

    protected $fillable = ['member_id', 'area_name', 'access_granted', 'reason'];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
