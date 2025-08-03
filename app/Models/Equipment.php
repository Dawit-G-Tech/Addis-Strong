<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Equipment extends Model
{
    use HasFactory;

    protected $primaryKey = 'eq_id';
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['eq_id', 'eq_name', 'quantity', 'eq_category', 'eq_status', 'date_of_buy'];
}

