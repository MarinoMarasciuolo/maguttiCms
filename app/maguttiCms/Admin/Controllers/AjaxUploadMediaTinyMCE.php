<?php

namespace App\maguttiCms\Admin\Controllers;

use App\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AjaxUploadMediaTinyMCE extends AjaxBaseMediaController
{

    /*
    |--------------------------------------------------------------------------
    |  Upload Image  From TinyMCE
    |--------------------------------------------------------------------------
    |  Filesystem Disk = > media
    |
    |
    */
    public function handle(Request $request)
    {

        if (!$request->hasFile('file') || !$request->file('file')->isValid()) {
            return response('Server error', 500);
        }

        $extension = $request->file('file')->extension();
        $file_path = $request->file('file')->storeAs('tinymce', Str::random(20) . '.' . $extension, 'images');
        $storage = Storage::disk('images');
        return response()->json([
            'location' => $storage->url($file_path)
        ]);
    }
}