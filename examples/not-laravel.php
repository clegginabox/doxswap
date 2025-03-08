<?php

$local = new League\Flysystem\Local\LocalFilesystemAdapter('/some/path');
$remote = new League\Flysystem\Local\LocalFilesystemAdapter('/some/other/remote/path');


$converter = new \Blaspsoft\Doxswap\ConversionService('/usr/bin/soffice');
$converter->convertFile(
    $local,
    '/some/path/sample.docx',
    $remote,
    '/some/path/sample.pdf',
    'pdf'
);
