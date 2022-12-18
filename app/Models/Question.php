<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Option;
use App\Models\Subject;
use App\Models\Test;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Question extends Model
{
    use HasFactory;

    const OPTION = 'option';
    const MULTI_CHOICE = 'multiple-choice';
    const NO_OPTION = 'no-option';

    protected $fillable = [
        'subject_id',
        'question',
        'type',
        'point',
        'option',
        'is_correct'
    ];

    const TYPES = [
        self::OPTION,
        self::MULTI_CHOICE,
        self::NO_OPTION
    ];


    public function options(){
        return $this->hasMany(Option::class);
    }

    public function subject(){
        return $this->belongsTo(Subject::class);
    }

    public function tests(){
        return $this->belongsToMany(Test::class);
    }

    public function getUpdatedAtAttribute($value)
    {
        return Carbon::createFromTimestamp(strtotime($value))->diffForHumans();
    }

    public function delete()    
    {
        DB::transaction(function() 
        {
            $this->options()->delete();
            parent::delete();
        });
    }

}
