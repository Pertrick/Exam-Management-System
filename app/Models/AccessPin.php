<?php

namespace App\Models;

use App\Models\User;
use App\Scopes\WebsiteScope;
use App\Traits\HasWebsiteId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AccessPin extends Model
{
    use HasFactory,HasWebsiteId;

    protected $guarded = [];

    public function creator(){
        return $this->belongsTo(User::class,"created_by");
    }

    public function usedBy(){
        return $this->belongsTo(User::class,"used_by");
    }
}
