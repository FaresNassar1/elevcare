<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => \Juzaweb\CMS\Facades\Facades::defaultFileSystemDisks()->merge(
        [
            'private' => [
                'driver' => 'local',
                'root' => storage_path('app/private'),
            ],
            'azure' => [
                'driver'    => 'azure',
                'name'      => env('AZURE_STORAGE_NAME'),
                'key'       => env('AZURE_STORAGE_KEY'),
                'container' => env('AZURE_STORAGE_CONTAINER'),
                'url'       => env('AZURE_STORAGE_URL'),
                'prefix'    => env('AZURE_STORAGE_PREFIX'),
                'retry'     => [
                    'tries' => 3,
                    'interval' => 500,
                    'increase' => 'exponential'
                ],
                /*
                'cache'     => [
                    'store' => 'filecache',
                    'expire' => 600,
                    'prefix' => 'filecache',
                ]
            */
            ],
        ]
    )->toArray(),

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
