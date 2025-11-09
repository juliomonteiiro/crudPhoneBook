<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'email',
        'image',
    ];

    public function getImageAttribute($value)
    {
        if ($value) {
            return '/storage/' . $value;
        }
        return null;
    }
}
