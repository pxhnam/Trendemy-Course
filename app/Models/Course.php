<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'lecturer',
        'thumbnail',
        'description',
        'fake_cost',
        'cost',
        'num_of_chapters',
        'num_of_lessons',
        'time_to_complete',
        'starts',
        'duration'
    ];
}
