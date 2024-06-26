<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subject;

class Resources extends Model
{
    use HasFactory;

    protected $fillable =['name', 'link', 'subject_id'];

    public function subject(){
        return $this->belongsTo(Subject::class);
    }
}
