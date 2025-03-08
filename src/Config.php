<?php

declare(strict_types=1);

namespace Blaspsoft\Doxswap;

/**
 * Not sure these want to be in the Laravel config?
 * Otherwise I could add 'jpeg' to 'xml' and break stuff?
 */
class Config
{
    /**
     * Maybe better as an enum?
     * Then the parameter on the conversion service could be an enum
     *
     * @return string[]
     */
    public static function supportedFileExtensions(): array
    {
        return [
            'doc',
            'docx',
            'odt',
            'rtf',
            'txt',
            'html',
            'epub',
            'xml',
            'csv',
            'xlsx',
            'xls',
            'ods',
            'pptx',
            'ppt',
            'odp',
            'svg',
            'jpg',
            'png',
            'bmp',
            'tiff',
        ];
    }

    public static function supportedConversions() : array
    {
        return [
            'doc' => [
                'pdf',
                'docx',
                'odt',
                'rtf',
                'txt',
                'html',
                'epub',
                'xml',
            ],

            'docx' => [
                'pdf',
                'odt',
                'rtf',
                'txt',
                'html',
                'epub',
                'xml',
            ],

            'odt' => [
                'pdf',
                'docx',
                'doc',
                'txt',
                'rtf',
                'html',
                'xml',
            ],

            'rtf' => [
                'pdf',
                'docx',
                'odt',
                'txt',
                'html',
                'xml',
            ],

            'txt' => [
                'pdf',
                'docx',
                'odt',
                'html',
                'xml',
            ],

            'html' => [
                'pdf',
                'odt',
                'txt',
            ],

            'xml' => [
                'pdf',
                'docx',
                'odt',
                'txt',
                'html',
            ],

            'csv' => [
                'pdf',
                'xlsx',
                'ods',
                'html',
            ],

            'xlsx' => [
                'pdf',
                'ods',
                'csv',
                'html',
            ],

            'xls' => [
                'pdf',
                'ods',
                'csv',
                'html',
            ],

            'ods' => [
                'pdf',
                'xlsx',
                'xls',
                'csv',
                'html',
            ],

            'pptx' => [
                'pdf',
                'odp',
            ],

            'ppt' => [
                'pdf',
                'odp',
            ],

            'odp' => [
                'pptx',
                'pdf',
            ],

            'svg' => [
                'pdf',
                'png',
                'jpg',
                'tiff',
            ],

            'jpg' => [
                'pdf',
                'png',
                'svg',
            ],

            'png' => [
                'pdf',
                'jpg',
                'svg',
            ],

            'bmp' => [
                'pdf',
                'jpg',
                'png',
            ],

            'tiff' => [
                'pdf',
                'jpg',
                'png',
            ],
        ];
    }
}
