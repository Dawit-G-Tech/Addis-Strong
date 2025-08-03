<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $primaryKey = 'role_id';
    public $timestamps = false;

    protected $fillable = ['role_name'];

    // Relationships
    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
