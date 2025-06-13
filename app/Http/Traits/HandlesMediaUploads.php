<?php

namespace App\Http\Traits;

use App\Models\Media;
use App\Models\Mediable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HandlesMediaUploads
{
    protected function getBasePath($model, $collection)
    {
        $class = class_basename($model);

        return match($class) {
            'Category'     => 'clients/categories',
            'Client'       => $collection === 'favicon' ? 'clients/favicons' : 'clients/logos',
            'Testimonial'  => 'clients/testimonials',
            'Product'      => 'clients/products',
            'Offer'        => 'clients/offers',
            default        => 'clients/' . Str::kebab($class)
        };
    }

    protected function uploadMedia($model, $file, $collection, $deleteOld = false)
    {
        try {
            $relationMethod = $this->determineRelationMethod($model, $collection);

            if ($deleteOld && $model->$relationMethod) {
                $this->deleteMedia($model->$relationMethod->media);
                $model->$relationMethod()->delete();
            }

            $basePath = $this->getBasePath($model, $collection);
            $extension = $file->getClientOriginalExtension();
            $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '-' . time() . '.' . $extension;

            $path = $file->storeAs(
                $basePath,
                $filename,
                'public'
            );

            $clientId = $class = class_basename($model) === 'Client' ? $model->id : $model->client_id;

            $media = Media::create([
                'client_id' => $clientId,
                'uuid' => Str::uuid()->toString(),
                'type' => $collection,
                'name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                'filename' => $filename,
                'path' => $path,
                'full_url' => $this->generateCorrectUrl($path),
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
                'disk' => 'public',
                'is_approved' => true,
            ]);

            return $model->$relationMethod()->create([
                'media_id' => $media->id,
                'collection' => $collection,
                'custom_properties' => [
                    'alt_text' => $file->getClientOriginalName()
                ]
            ]);

        } catch (\Exception $e) {
            throw new \Exception("Error al subir el archivo: " . $e->getMessage());
        }
    }

    protected function deleteMedia($media)
    {
        try {
            // Eliminar archivo físico
            if (Storage::disk($media->disk)->exists($media->path)) {
                Storage::disk($media->disk)->delete($media->path);
            }

            // Eliminar registro de la base de datos
            $media->delete();

        } catch (\Exception $e) {
            throw new \Exception("Error al eliminar el archivo: " . $e->getMessage());
        }
    }

    protected function generateCorrectUrl($path)
    {
        $cleanPath = str_replace('public/', '', $path);
        return asset("storage/{$cleanPath}");
    }

    protected function determineRelationMethod($model, $collection)
    {
        if (class_basename($model) === 'Client') {
            return $collection === 'favicon' ? 'favicon' : 'logo';
        }
        
        if (class_basename($model) === 'Product') {
        return $collection === 'product_gallery' ? 'featuredImage' : 'image';
    }

        return 'image';
    }
}
