<?php

// app/Http/Controllers/MediaController.php

namespace App\Http\Controllers;

use App\Models\Media;
use App\Models\Mediable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class MediaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|image|max:5120',
            'model_type' => 'required|string',
            'model_id' => 'required|integer',
            'collection' => 'required|string'
        ]);
        
        $file = $request->file('file');
        $path = $file->store('uploads/' . $request->collection, 'public');
        
        $media = Media::create([
            'client_id' => auth()->user()->client_id,
            'uuid' => Str::uuid()->toString(),
            'type' => $request->collection,
            'name' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            'filename' => $file->getClientOriginalName(),
            'path' => $path,
            'full_url' => Storage::url($path),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'disk' => 'public',
            'is_approved' => true, // Asumimos que el archivo es aprobado por defecto
        ]);
        
        // Crear relación polimórfica
        $mediable = Mediable::create([
            'media_id' => $media->id,
            'mediable_type' => $request->model_type,
            'mediable_id' => $request->model_id,
            'collection' => $request->collection
        ]);
        
        return response()->json([
            'success' => true,
            'media' => $media,
            'mediable' => $mediable
        ]);
    }
    
    public function destroy(Media $media)
    {
        Storage::disk($media->disk)->delete($media->path);
        $media->delete();
        
        return response()->json(['success' => true]);
    }
}