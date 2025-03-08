<?php

declare(strict_types=1);

namespace Blaspsoft\Doxswap;

use Blaspsoft\Doxswap\Exceptions\ConversionFailedException;
use Blaspsoft\Doxswap\Exceptions\UnsupportedConversionException;
use Blaspsoft\Doxswap\Exceptions\UnsupportedMimeTypeException;
use League\Flysystem\FilesystemAdapter;
use Symfony\Component\Mime\MimeTypes;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ConversionService
{
    protected ?string $libreOfficePath;

    protected ?string $libreOfficeArgs;

    protected MimeTypes $mimeTypes;

    public function __construct(?string $libreOfficePath = null, ?string $libreOfficeArgs = null)
    {
        $this->libreOfficePath = $libreOfficePath;
        $this->libreOfficeArgs = $libreOfficeArgs;
        $this->mimeTypes = new MimeTypes();
    }

    /**
     * @param FilesystemAdapter $sourceFs
     * @param string $sourceFilePath
     * @param FilesystemAdapter $destinationFs
     * @param string $destinationFilePath
     * @param string $conversionType Make this an enum?
     *
     * @return string
     *
     * @throws ConversionFailedException
     * @throws UnsupportedConversionException
     * @throws UnsupportedMimeTypeException
     */
    public function convertFile(
        FilesystemAdapter $sourceFs,
        string $sourceFilePath,
        FilesystemAdapter $destinationFs,
        string $destinationFilePath,
        string $conversionType
    ): string
    {
        if (!$sourceFs->fileExists($sourceFilePath)) {
            throw new ConversionFailedException('File does not exist');
        }

        /**
         * https://symfony.com/doc/current/components/mime.html#guessing-the-mime-type
         */
        $sourceFileMimeType = $this->mimeTypes->guessMimeType($sourceFilePath);

        if (!$this->isSupportedMimeType($sourceFileMimeType)) {
            throw new UnsupportedMimeTypeException($sourceFileMimeType);
        }

        $sourceFileExtensions = $this->mimeTypes->getExtensions($sourceFileMimeType);

        if (!$this->isSupportedConversion($sourceFileExtensions, $conversionType)) {
            throw new UnsupportedConversionException($sourceFileExtensions, $conversionType);
        }

        try {
            $this->process($sourceFilePath, $conversionType, $destinationFs->path($destinationFilePath));
        } catch (ProcessFailedException $e) {
            throw new ConversionFailedException($e->getMessage());
        }

        return $destinationFilePath;
    }

    /**
     * Process the file conversion
     *
     * @param string $sourceFilePath
     * @param string $format
     * @param string $destinationFilePath
     *
     * @return void
     */
    protected function process(string $sourceFilePath, string $format, string $destinationFilePath): void
    {
        $command = [
            $this->libreOfficePath,
            $this->libreOfficeArgs,
            '--headless',
            '--convert-to', $format ,
            '--outdir', $destinationFilePath,
            $sourceFilePath,
        ];

        $process = new Process($command);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    }

     /**
     * Check if the conversion is supported.
     *
     * @param array $sourceExtensions
     * @param string $toExtension
     * @return bool
     */
    protected function isSupportedConversion(array $sourceExtensions, string $toExtension): bool
    {
        $supportedConversions = Config::supportedConversions();

        $matchingSource = array_filter($sourceExtensions, static function ($source) use ($supportedConversions) {
            return array_key_exists($source, $supportedConversions);
        });

        $firstMatchingSource = reset($matchingSource);

        return in_array($toExtension, $supportedConversions[$firstMatchingSource]);
    }

    /**
     * Check if the mime type is supported.
     *
     * @param string $mimeType
     * @return bool
     */
    protected function isSupportedMimeType(string $mimeType): bool
    {
        $symfonyMimeType = $this->mimeTypes;

        $supportedMimeTypes = array_merge(...array_map(static function ($type) use ($symfonyMimeType) {
            return $symfonyMimeType->getMimeTypes($type);
        }, Config::supportedFileExtensions()));

        return in_array(
            $mimeType,
            $supportedMimeTypes,
            true
        );
    }
}
