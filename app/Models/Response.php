<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Result;
use App\Models\Test;
use App\Models\Question;

class Response extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'test_id', 'question_id', 'answer'];

    public function setAnswerAttribute($value){
        $this->attributes['answer'] = json_encode($value);
    }

    public function getAnswerAttribute($value){
        return json_decode($value);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function result()
    {
        return $this->belongsTo(Result::class);
    }

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

}
