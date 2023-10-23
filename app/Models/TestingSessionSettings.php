<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestingSessionSettings extends Model
{
    use HasFactory;

    public $fillable = [
        'time',
        'shuffle_questions',
        'shuffle_options',
        'show_result',
        'points_min',
        'points_max',
    ];

}
