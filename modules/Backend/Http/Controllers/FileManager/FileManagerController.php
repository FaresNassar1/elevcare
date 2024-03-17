<?php

namespace Juzaweb\Backend\Http\Controllers\FileManager;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use Juzaweb\CMS\Http\Controllers\BackendController;

class FileManagerController extends BackendController
{
    protected static string $success_response = 'OK';

    public function index(Request $request): View
    {
        $type = explode("-", $this->getType())[0];
        $mimeTypes = config("juzaweb.filemanager.types.{$type}.valid_mime");
        $maxSize = config("juzaweb.filemanager.types.{$type}.max_size");
        $multiChoose = $request->get('multichoose', 0);
        $lang = $request->get('lang', Lang::Locale());

        if (empty($mimeTypes)) {
            abort(404);
        }

        return view(
            'cms::backend.filemanager.index',
            compact(
                'mimeTypes',
                'maxSize',
                'multiChoose',
                'lang'
            )
        );
    }

    public function getErrors(): array
    {
        $errors = [];
        if (!extension_loaded('gd') && !extension_loaded('imagick')) {
            $errors[] = trans_cms('cms::filemanager.message_extension_not_found', ['name' => 'gd']);
        }

        if (!extension_loaded('exif')) {
            $errors[] = trans_cms('cms::filemanager.message_extension_not_found', ['name' => 'exif']);
        }

        if (!extension_loaded('fileinfo')) {
            $errors[] = trans_cms('cms::filemanager.message_extension_not_found', ['name' => 'fileinfo']);
        }

        return $errors;
    }

    public function throwError($type, $variables = [])
    {
        throw new \Exception(trans_cms('cms::filemanager.error_' . $type, $variables));
    }

    protected function getType(): string
    {
        $type = strtolower(request()->get('type'));

        return Str::singular($type);
    }

    protected function getPath($url): string
    {
        $explode = explode('uploads/', $url);
        if (isset($explode[1])) {
            return $explode[1];
        }

        return $url;
    }

    protected function isDirectory($file): bool
    {
        if (is_numeric($file)) {
            return true;
        }

        return false;
    }
}