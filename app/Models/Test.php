<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subject;
use App\Models\Question;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Test extends Model
{
    use HasFactory;

    const PUBLISHED = 1, UNPUBLISHED =0;


    protected $fillable = [
        'subject_id',
        'duration'
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

    public function delete()
    {
        DB::transaction(function () {
            $this->questions()->detach();
            parent::delete();
        });
    }
}
