<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use Cloudinary\Cloudinary;
use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    public function store(ImageUploadRequest $request, Cloudinary $cld)
    {
        $image = $request->file('image');
        if (!$image) {
            return response()->json(['error' => 'No image uploaded'], 400);
        }

        $imagePath = $image->getRealPath();
        $upload = $cld->uploadApi()->upload($imagePath, [
            'folder' => 'tiptap',
        ]);

        $url = $cld->image($upload['public_id'])->quality('auto')->format('auto')->toUrl();
        return response()->json(['url' => $url]);
    }
}
