<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChannelProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_name',
        'description',
        'status',
        'start_date',
        'end_date',
    ];
}
