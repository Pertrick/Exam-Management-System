<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subject;
use App\Models\Question;
use Illuminate\Support\Facades\DB;

class Test extends Model
{
    use HasFactory;

    protected $fillable =[
        'subject_id',
        'duration'
    ];

    public function subject(){
        return $this->belongsTo(Subject::class);
    }

    public function questions(){
        return $this->belongsToMany(Question::class);
    }

    public function delete()    
    {
        DB::transaction(function() 
        {
            $this->questions()->detach();
            parent::delete();
        });
    }
}
