<?php

namespace App\Models;

use App\Models\Response;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TestUser extends Pivot
{
    protected $table = 'test_user';

    protected $fillable = [
        'test_id',
        'user_id',
        'start_time',
        'end_time',
        'status'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime'
    ];

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function result()
    {
        return $this->hasOne(Result::class);
    }

    public function calculateDuration()
    {
        if ($this->start_time && $this->end_time) {
            return $this->end_time->diffInSeconds($this->start_time);
        }
        return null;
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }
} 