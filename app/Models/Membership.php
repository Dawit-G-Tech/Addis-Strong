<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Membership extends Model
{
    use HasFactory;

    protected $primaryKey = 'membership_id';
    public $timestamps = false;

    protected $fillable = ['name', 'duration_months', 'price', 'access_level', 'status'];

    public function members()
    {
        return $this->hasMany(Member::class, 'membership_id');
    }
}
