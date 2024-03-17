<?php

/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://github.com/juzaweb/juzacms
 * @license    GNU V2
 */

use Juzaweb\Backend\Http\Controllers\Backend\CommentController;
use Juzaweb\Backend\Http\Controllers\Backend\TaxonomyController;
use Juzaweb\Backend\Http\Controllers\Backend\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;


Route::jwResource(
    'post-type/{type}/comments',
    CommentController::class,
    [
        'name' => 'comments'
    ]
);

Route::jwResource(
    'taxonomy/{type}/{taxonomy}',
    TaxonomyController::class,
    [
        'name' => 'taxonomies'
    ]
);

Route::get(
    'taxonomy/{type}/{taxonomy}/component-item',
    [TaxonomyController::class, 'getTagComponent']
);

Route::jwResource(
    'post-type/{type}',
    PostController::class,
    [
        'name' => 'posts'
    ]
);


Route::get('/upload-image', function () {
    return view('cms::backend.pages.index');
});

Route::get('/azure-get-all', function () {
    $path = '/uploads';

    // Get the Larvel disk for Azure
    $disk = Storage::disk('azure');

    // List files in the container path
    $files = $disk->files($path);

    // create an array to store the names, sizes and last modified date
    $list = array();

    // Process each filename and get the size and last modified date
    foreach ($files as $file) {
        $size = $disk->size($file);

        $modified = $disk->lastModified($file);
        $modified = date("Y-m-d H:i:s", $modified);

        $filename = "$path/$file";

        $item = array(
            'name' => $filename,
            'size' => $size,
            'modified' => $modified,
        );

        array_push($list, $item);
    }

    $results = json_encode($list, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

    return response($results)->header('content-type', 'application/json');
});


Route::get('/azure-url', function () {

    // $disk = Storage::disk('azure');

    // $path = "uploads//1707134627_images.jfif";

    $filename = "uploads/1707135667_1707134627_images (1).jfif";

    $disk = Storage::disk('azure');

    if (!$disk->exists($filename)) {
        abort(404);
    }

    $contents = $disk->get($filename);

    Storage::disk('azure')->put($filename,  $contents);

    // Get public URL
    $url = Storage::disk('azure')->url($filename);


    return $url;
});


Route::get('/azure-url-direct', function () {

    $disk = Storage::disk('azure');

    $path = "uploads/1707223445_Intaleq-Logo.png";

    // SAS Expires in one hour
    $ttl = now()->addSecond(10);

    $options = [
        'signed_permissions' => 'rw'
    ];

    $url = $disk->temporaryUrl($path, $ttl, $options);


    return $url;
});

Route::get('/azure-file', function () {
    $filename = "uploads//1707223445_Intaleq-Logo.png";

    $disk = Storage::disk('azure');

    if (!$disk->exists($filename)) {
        abort(404);
    }

    $contents = $disk->get($filename);

    return response($contents)->header('content-type', 'image/jpeg');
});

Route::post('/upload', function (Request $req) {
    $req->validate([
        'file' => 'required'
    ]);

    if ($req->file()) {
        $fileName = time() . '_' . $req->file->getClientOriginalName();
        // save file to azure blob virtual directory uplaods in your container
        $filePath = $req->file('file')->storeAs('uploads/', $fileName, 'azure');
        dd($filePath, $fileName);
        return back()->with('success', 'File has been uploaded.');
    }
})->name('upload');
