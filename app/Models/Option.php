<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

}
