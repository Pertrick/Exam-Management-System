<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Test;
use App\Models\User;
use App\Models\TestUser;
use App\Traits\HasWebsiteId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Result extends Model
{
    use HasFactory, HasWebsiteId;

    const PASSED = 1;
    const FAILED = 0;

    protected $fillable = [
        'test_user_id',
        'score',
        'score_percentage',
        'status',
        'website_id'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function testUser()
    {
        return $this->belongsTo(TestUser::class);
    }

    public function user()
    {
        return $this->hasOneThrough(User::class, TestUser::class, 'id', 'id', 'test_user_id', 'user_id');
    }
}
