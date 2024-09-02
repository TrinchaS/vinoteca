<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UploadService
{
    public static function upload(UploadedFile $file, string $folder, $disk = 'public'): string{
        // obtenemos el nombre del archivo
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        // obtenemos la extension
        $extension = $file->getClientOriginalExtension();
        //añadimos la marca de tiempo
        $filename = $filename.'-'.time().'.'.$extension;
        
        return $file->storeAs($folder,$filename,$disk);
    }

    public static function delete(string $path, $disk = 'public'): bool {
        if(!Storage::disk($disk)->exists($path)){
            return false;
        }
        return Storage::disk($disk)->delete($path);
    }

    //no accedemos al contenido solo a la url
    public static function url(string $path, string $disk = 'public'): string{
        return Storage::url($path); //disk($disk)->url($path) o Storage::disk($disk)->url;
    }
}
