<?php

return [

    /*
    |--------------------------------------------------------------------------
    | LibreOffice Path
    |--------------------------------------------------------------------------
    |
    | Here you may specify the path to the LibreOffice binary.
    |
    | Default Linux path: /usr/bin/soffice
    | Default Mac path: /Applications/LibreOffice.app/Contents/MacOS/soffice
    | Default Windows path: C:\Program Files\LibreOffice\program\soffice.exe
    |--------------------------------------------------------------------------
    */
    'libre_office_path' => env('LIBRE_OFFICE_PATH', '/usr/bin/soffice'),
    'libre_office_args' => env('LIBRE_OFFICE_ARGS', ''),

];
