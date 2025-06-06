<?php
// app/Http/Traits/HandlesMediaUploads.php

namespace App\Http\Traits;

use App\Models\Media;
use App\Models\Mediable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HandlesMediaUploads
{
    protected function uploadMedia($model, $file, $collection, $deleteOld = false)
    {
        if ($deleteOld && $model->image) {
            $this->deleteMedia($model->image->media);
        }
        
        $path = $file->store('uploads/' . $collection, 'public');
        $filename = 'logo-' . $this->id . '-' . time() . '.' . $file->getClientOriginalExtension();
        
        $media = Media::create([
            'client_id' => $model->client_id,
            'uuid' => Str::uuid()->toString(),
            'type' => $collection,
            'name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'filename' => $filename,
            'path' => $path,
            'full_url' => Storage::url($path),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'disk' => 'public',
            'is_approved' => true, // Asumimos que el archivo es aprobado por defecto
        ]);
        
        return $model->image()->create([
            'media_id' => $media->id,
            'collection' => $collection,
            'custom_properties' => [
                'alt_text' => $file->getClientOriginalName()
            ]
        ]);
    }
    
    protected function deleteMedia($media)
    {
        Storage::disk($media->disk)->delete($media->path);
        $media->delete();
    }
}