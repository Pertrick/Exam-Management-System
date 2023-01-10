<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Test;
use App\Models\Response;
use App\Models\Result;
use App\Models\Subject;
use App\Models\Payment;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function tests()
    {
        return $this->belongsToMany(Test::class)->withTimestamps();
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class)->withTimestamps();
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::createFromTimeStamp(strtotime($value))->diffForHumans();
    }

    public function getRedirectRouteName(): string{
        return match((int)$this->role_id){
          Role::ADMIN => 'admin.dashboard',
          Role::USER => 'student.dashboard'
        };
    }


}
