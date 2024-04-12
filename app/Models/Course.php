<?php

namespace App\Models;

use App\Models\User;
use App\Models\Program;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'capped', 'description'];


    public function programs(){
        return $this->belongsToMany(Program::class)->withTimestamps();
    }

    public function users(){
        return $this->belongsToMany(User::class)->withTimestamps();
    }


    public function subjects()
    {
        return $this->belongsToMany(Subject::class)->withTimestamps();
    }
}
