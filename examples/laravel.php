<?php

use Illuminate\Support\Facades\Storage;

/** The service provider is injecting the config */
$converter = $this->app->make('doxswap');

$outputFilePath = $converter->convertFile(
    Storage::disk('local'),
    Storage::disk('local')->path('test.docx'),
    Storage::disk('remote'),
    'sample.pdf',
    'pdf'
);


