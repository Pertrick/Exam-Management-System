<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;
use App\Models\Image;

class Option extends Model
{
    use HasFactory;
    protected $fillable =[
        'question_id',
        'label',
        
    ];

     /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $cast =[
        'is_correct' => 'boolean'
    ];

    public function setIsCorrectAttribute($value){
        ($value == "on") ? $this->attributes['is_correct'] = 1 : $this->attributes['is_correct'] = 0; 
        
    }

    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function image(){
        return $this->morphOne(Image::class, 'imageable');
    }

    public function delete()    
    {
        DB::transaction(function() 
        {
            $this->image()->delete();
            parent::delete();
        });
    }

}
