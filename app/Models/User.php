<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use App\Models\Test;
use App\Models\Course;
use App\Models\Result;
use App\Models\Payment;
use App\Models\Subject;
use App\Models\Website;
use App\Models\Response;
use App\Models\Resources;
use App\Scopes\WebsiteScope;
use App\Traits\HasWebsiteId;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasWebsiteId;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
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

    public function website()
    {
        return $this->belongsTo(Website::class);
    }

    public function tests()
    {
        return $this->belongsToMany(Test::class)->withTimestamps();
    }

    public function responses()
    {
        return $this->hasManyThrough(Response::class, TestUser::class, 'user_id', 'test_user_id', 'id', 'id');
    }

    public function results()
    {
        return $this->hasManyThrough(Result::class, TestUser::class, 'user_id', 'test_user_id', 'id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function testUsers()
    {
        return $this->belongsToMany(Test::class, 'test_user')
                    ->withPivot('start_time', 'end_time', 'status')
                    ->withTimestamps();
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class)
                    ->withPivot('expires_at')
                    ->withTimestamps();
    }

    public function activeSubjects()
    {
        return $this->subjects()->wherePivot('expires_at', '>', now());
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::createFromTimeStamp(strtotime($value))->diffForHumans();
    }

    public function getRedirectRouteName(): string{
        return match((int)$this->role_id){
          Role::ADMIN => 'admin.dashboard.index',
          Role::USER => 'student.dashboard'
        };
    }

    public function passedResults(){
        return $this->results()->where('results.status', 1);
    }

    public function failedResults(){
        return $this->results()->where('results.status', 0);
    }


    public function studentAccessPin(){
        return $this->hasMany(AccessPin::class, 'used_by');
    }


    public function courses(){
        return $this->belongsToMany(Course::class)->withTimestamps();
    }
}
