<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

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
}
