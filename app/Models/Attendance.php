<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'internship_id',
        'date',
        'check_in',
        'check_out',
    ];

    // Relasi ke model Internship
    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }
}
