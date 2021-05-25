<?php

namespace Mi\Core\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Mi\Core\Concerns\File\DetectMimeType;
use Mi\Core\Concerns\File\File;
use Mi\Core\Exceptions\FileException;

trait HasImageUploadTrait
{
    /**
     * Prepare images for create
     *
     * @param string $filePath
     * @return array|null
     */
    protected function prepareImageForCreate(?string $filePath)
    {
        if (! $filePath) {
            return null;
        }

        return $this->getImageData($filePath);
    }

    /**
     * Get image data from PRESIGNED PATH
     *
     * @param string $path
     * @return array
     */
    protected function getImageData(string $path)
    {
        if (! ($imageSize = getimagesize(Storage::temporaryUrl($path, Carbon::now()->addMinute())))) {
            throw FileException::invalidPath();
        }

        $imageInfo = pathinfo($path);

        return File::makeDefaultImageAttributes([
            'name' => $imageInfo['basename'],
            'extension' => $imageInfo['extension'],
            'mime_type' => DetectMimeType::getMimeType($imageInfo['extension']),
            'width' => $imageSize[0] ?? 1,
            'height' => $imageSize[1] ?? 1,
            'original_path' => ltrim($path, 'presigned/'),
            'presigned_path' => $path
        ]);
    }

    /**
     * Move image to private path
     *
     * @param array $newImagesData
     * @return void
     */
    protected function moveImageToPrivatePath(array $newImagesData)
    {
        foreach ($newImagesData as $imageData) {
            Storage::move($imageData['presigned_path'], $imageData['original_path']);
            Storage::setVisibility($imageData['original_path'], 'private');
        }
    }

    /**
     * Check image is presigned path
     *
     * @param string $path
     * @return boolean
     */
    protected function isPresignedPath(string $path)
    {
        return preg_match('/^presigned\//', $path);
    }

    /**
     * Remove image
     *
     * @param string $path
     * @return void
     */
    protected function removeImage(string $path)
    {
        Storage::delete($path);
    }
}
