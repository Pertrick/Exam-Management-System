<?php

namespace App\Models;

use App\Models\Test;
use App\Models\User;
use App\Models\Course;
use App\Models\Resources;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


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

    // public function students()
    // {
    //     return $this->belongsToMany(Student::class)->withTimestamps();
    // }

    public function resources()
    {
        return $this->hasMany(Resources::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class)->withTimestamps();
    }

}
