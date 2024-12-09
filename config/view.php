<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Here you may specify an array of paths that should be checked for your
    | views. These paths will be checked in the order they are listed.
    |
    */

    'paths' => [
        resource_path('views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Blade views will be stored.
    | By default, this is within the storage directory. You may change this
    | if you wish to store the compiled views in a different location.
    |
    */

    'compiled' => realpath(storage_path('framework/views')),

];
