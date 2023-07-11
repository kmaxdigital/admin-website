<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */
    'movie_path' => [
        'input' => env('MOVIE_INPUT_PATH'),
        'output' => env('MOVIE_OUTPUT_PATH'),
    ],

    'episode_path' => [
        'input' => env('EPISODE_INPUT_PATH'),
        'output' => env('EPISODE_OUTPUT_PATH'),
    ],

];
