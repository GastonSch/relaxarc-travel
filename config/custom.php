<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Hide Deprecated Warnings
    |--------------------------------------------------------------------------
    |
    | Configure error reporting to hide deprecated warnings while in development
    | with PHP 8.4 and Laravel 8.x compatibility issues
    |
    */
    
    'hide_deprecated_warnings' => env('HIDE_DEPRECATED_WARNINGS', true),
    
    /*
    |--------------------------------------------------------------------------
    | Development Settings
    |--------------------------------------------------------------------------
    */
    
    'development_mode' => env('APP_ENV') === 'local',
];
