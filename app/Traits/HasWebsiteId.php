<?php
namespace App\Traits;

use App\Scopes\WebsiteScope;

trait HasWebsiteId
{
    /**
     * Boot the trait into the model.
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->website_id) {
                $model->website_id = auth()->user()->website_id ?? config('website.default_website_id');
            }
        });

        static::addGlobalScope(new WebsiteScope);
    }
}
