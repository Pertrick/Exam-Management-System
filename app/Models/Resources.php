<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subject;
use Ramsey\Uuid\Uuid;

class Resources extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',  'uuid', 'description', 
        'subject_id', 'cover_image','resource',
        'pdf_file','uploaded_video','video_url'
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }


    public function scopeSearch($query, $searchParam)
    {
        if (!isset($searchParam) || empty($searchParam)) {
            return $query;
        }

        return  $query->where('name', 'like', "%$searchParam%")
            ->orWhere('description', 'like', "%$searchParam%");
    }


    protected static function boot()
    {
        parent::boot();

        // Generate a UUID for the new resources
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }
}
