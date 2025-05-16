<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Result;
use App\Models\Test;
use App\Models\Question;
use App\Models\TestUser;

class Response extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_user_id',
        'question_id',
        'answer',
        'result_id',
        'is_correct'
    ];

    public function setAnswerAttribute($value){
        $this->attributes['answer'] = json_encode($value);
    }

    public function getAnswerAttribute($value){
        return json_decode($value);
    }

    public function result()
    {
        return $this->belongsTo(Result::class);
    }


    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function testUser()
    {
        return $this->belongsTo(TestUser::class);
    }

    public function test()
    {
        return $this->hasOneThrough(Test::class, TestUser::class, 'id', 'id', 'test_user_id', 'test_id');
    }

    public function user()
    {
        return $this->hasOneThrough(User::class, TestUser::class, 'id', 'id', 'test_user_id', 'user_id');
    }
}
