<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class History extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'disease'];

    public function solutionData(){
        return $this->hasOne(Disease::class, 'name', 'disease');
    }

    public function getImageAttribute($value)
    {
        if ($value) {
            return $value;
        }

        return asset('assets/img/logo.png');
    }
}
