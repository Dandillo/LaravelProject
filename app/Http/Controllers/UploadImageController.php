<?php

namespace App\Http\Controllers;

use App\Traits\FileUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadImageController extends Controller
{
    use FileUploader;

    public function store(Request $request)
    {
        $image_path = $this->upload_image($request->file('file'),null, 'uploads');
        $image_url = Storage::url($image_path);
        return response()->json(['location' => $image_url]);
    }
}
