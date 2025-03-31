<?php

namespace App\Models;

use App\Models\User;
use App\Scopes\WebsiteScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccessPin extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function creator(){
        return $this->belongsTo(User::class,"created_by");
    }

    public function usedBy(){
        return $this->belongsTo(User::class,"used_by");
    }

    
    protected static function booted()
    {
        static::addGlobalScope(new WebsiteScope);

        static::creating(function ($model) {
            $model->website_id = User::WEBSITE_ID;
        });
    }
}
