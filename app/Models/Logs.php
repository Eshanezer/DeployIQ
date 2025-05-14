<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'path', 'predicted_path', 'status'];

    public function errorLogs(){
        return $this->hasMany(ErrorLog::class, 'logs_id', 'id');
    }
}
