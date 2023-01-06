<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subject;
use App\Models\Question;
use App\Models\User;
use App\Models\Response;
use Illuminate\Support\Facades\DB;

class Test extends Model
{
    use HasFactory;

    const PUBLISHED = 1, UNPUBLISHED =0;


    protected $fillable = [
        'subject_id',
        'duration',
        'pass_mark'
    ];


    protected $cast =[
        'is_published' => 'boolean'
    ];


    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }


    public function delete()
    {
        DB::transaction(function () {
            $this->responses()->delete();
            $this->results()->delete();
            $this->questions()->detach();
            parent::delete();
        });
    }
}
