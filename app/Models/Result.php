<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Test;

class Result extends Model
{
    use HasFactory;

    const PASSED = 1;
    const FAILED = 0;

    protected $fillable =['user_id', 'test_id', 'score', 'score_percentage', 'status'];

    protected $cast =[
        'status' =>'boolean',
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }
    
}
