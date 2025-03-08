<?php

declare(strict_types=1);

namespace Blaspsoft\Doxswap;

class Conversions
{
    public static function isSupportedMimeType(string $fromExtension): bool
    {
        return in_array($fromExtension, ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx']);
    }
}
