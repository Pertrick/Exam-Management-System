<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subject;

class Test extends Model
{
    use HasFactory;

    protected $fillable =[

    ];

    public function subjects(){
        return $this->belongsTo(Subject::class);
    }
}
