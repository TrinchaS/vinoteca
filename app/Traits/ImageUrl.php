<?php

namespace App\Traits;

use App\Services\UploadService;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait ImageUrl
{
    public function imageUrl(): Attribute{
        //image_url
        return Attribute::make(
            get: fn() => UploadService::url($this->image),
        );
    }
}
