<?php

namespace Blaspsoft\Doxswap\Exceptions;

use Exception;

class UnsupportedConversionException extends Exception
{
    public function __construct(array $fromExtensions, string $toExtension)
    {
        $extensions = implode(',', $fromExtensions);

        $message = "Conversion from '{$extensions}' to '{$toExtension}' is not supported";
        parent::__construct($message, 0); // Note the integer 0 for code
    }
}
