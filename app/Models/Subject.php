<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Test;
use App\Model\User;
use App\Models\Resources;


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

    public function students()
    {
        return $this->belongsToMany(Student::class)->withTimestamps();
    }

    public function resources()
    {
        return $this->hasMany(Resources::class);
    }
}
