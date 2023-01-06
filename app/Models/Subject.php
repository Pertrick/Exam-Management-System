<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Test;
use App\Model\User;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'description'];

    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
