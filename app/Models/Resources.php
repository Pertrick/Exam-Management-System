<?php

namespace App\Models;

use Ramsey\Uuid\Uuid;
use App\Models\Subject;
use App\Traits\HasWebsiteId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Resources extends Model
{
    use HasFactory,HasWebsiteId;

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
