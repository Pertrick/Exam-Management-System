<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'url',
    ];

    public static function getWebsiteBySlug($slug)
    {
        return self::where('slug', $slug)->first(); 
    }

    
}
