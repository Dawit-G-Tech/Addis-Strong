<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PerformanceReport extends Model
{
    use HasFactory;

    protected $primaryKey = 'report_id';
    public $timestamps = false;

    protected $fillable = [
        'report_date', 'total_members', 'new_signups',
        'total_revenue', 'class_attendance', 'notes'
    ];
}

