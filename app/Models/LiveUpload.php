<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class LiveUpload extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'is_new'];

    public function getImageAttribute($value)
    {
        if ($value && Storage::disk('public')->exists($value)) {
            return asset('storage/' . $value);
        }

        return asset('assets/img/logo.png');
    }
}
