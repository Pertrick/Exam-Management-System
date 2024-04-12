<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Test;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
