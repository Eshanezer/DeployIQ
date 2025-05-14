<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ErrorLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'logs_id',
        'timestamp',
        'level',
        'event_id',
        'message',
        'event_template',
        'suggestion',
        'pipeline_stage',
        'technology_stack',
        'triggered_by',
        'error_level',
        'security_vulnerability',
        'error_impact_area',
        'error_priority'
    ];
}
