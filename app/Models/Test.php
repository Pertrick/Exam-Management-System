<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Subject;
use App\Models\Question;
use App\Models\Response;
use App\Models\TestType;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Test extends Model
{
    use HasFactory;

    const PUBLISHED = 1, UNPUBLISHED = 0;


    protected $fillable = [
        'subject_id',
        'test_type_id',
        'duration',
        'instruction',
        'pass_mark',
        'start_date',
        'end_date'

    ];


    protected $cast = [
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
        return $this->belongsToMany(User::class)->withPivot(['start_time', 'end_time'])->withTimestamps();
    }

    public function responses()
    {
        return $this->hasMany(Response::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }


    public function delete()
    {
        DB::transaction(function () {
            $this->responses()->delete();
            $this->results()->delete();
            $this->questions()->detach();
            parent::delete();
        });
    }

    public function testType()
    {
        return $this->belongsTo(TestType::class);
    }

    public function getStartDateAttribute($value)
    {
        if (is_null($value)) {
            return null;
        }
        return Carbon::parse($value)->format('M d Y H:i:s');
    }

    public function getEndDateAttribute($value)
    {
        if (is_null($value)) {
            return null;
        }
        return Carbon::parse($value)->format('M d Y H:i:s');
    }
}
