<?php

namespace App\Models;

use App\Traits\HasWebsiteId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory,HasWebsiteId;

    protected $fillable =
    [
        'primary_color',
        'secondary_color',
        'main_color',
        'cover_image'
    ];
}
