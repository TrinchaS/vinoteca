<?php

namespace App\Models;

use App\Traits\HasSlug;
use App\Traits\ImageUrl;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasSlug;
    use ImageUrl;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image'
    ];

    public function wines(){
        return $this->hasMany(Wine::class);
    }

}
