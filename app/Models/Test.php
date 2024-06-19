<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Subject;
use App\Models\Question;
use App\Models\Response;
use App\Models\TestType;
use Illuminate\Support\Str;
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
        'end_date',
        'is_published',
        'test_id'

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
        return $this->hasMany(Question::class);
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
        return Carbon::parse($value)->format('M d Y g:i A');
    }

    public function getEndDateAttribute($value)
    {
        if (is_null($value)) {
            return null;
        }
        return Carbon::parse($value)->format('M d Y g:i A');
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($test) {
            $test->test_id = 'test-' . substr(self::generateRandomCodes(), 0, 10);
        });
    }


    public static function generateRandomCodes()
    {
        $code = Str::random(16);

        $customCode = '';
        for ($i = 0; $i < strlen($code); $i++) {
            $char = $code[$i];
            if (ctype_alpha($char)) {
                $customCode .= (rand(0, 1) === 0) ? strtoupper($char) : $char;
            } else {
                $customCode .= $char;
            }
        }

        return $customCode;
    }


    public function scopeSearch($query, $searchValue)
    {
        if (!$searchValue || !isset($searchValue) || is_null($searchValue)) {
            return $query;
        }

        if (strtolower($searchValue) == "closed") {
            $searchValue = 0;
        } else if (strtolower($searchValue) == "open") {
            $searchValue = 1;
        }

        return $query->where(function ($q) use ($searchValue) {
            $q->Where("is_published", "$searchValue");
        })->orWhereHas('subject', fn ($q) => $q->where('name', 'like', "%$searchValue%"))
            ->orWhereHas('testType', fn ($q) => $q->where("name", "like", "%$searchValue"));
    }
}
