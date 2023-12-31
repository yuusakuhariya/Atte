<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rest extends Model
{
    use HasFactory;

    protected $table = 'rests_tables';

    protected $fillable = [
        'attendance_id',
        'start_rest_time',
        'end_rest_time',
        'rest_time'
    ];

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }
}
