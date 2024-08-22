<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    //en lugar de consultar la PK consultamos la columna slug
    public function getRouteKeyName(): string{
        return 'slug';
    }

    //se ejecuta de forma automatica al poner 'use HasSlug'
    public static function bootHasSlug():void{

        //se ejecuta al disparar el evento de saving (de guardado y actualizacion)
        static::saving(function ($model){
            $model->slug = Str::slug($model->name);
        });

    }
}
