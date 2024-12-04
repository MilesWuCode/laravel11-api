<?php

namespace App\Traits;


use Spatie\Image\Image;

trait FactoryHelperTrait
{
    /**
     * Select a random image from a specified directory, resize it, and return its filename and base64 representation.
     *
     * @param string $path The directory path where images are stored.
     * @return array An array containing the filename and base64 encoded image.
     * @throws \Exception If the path is empty or no images are found in the directory.
     */
    public function randomImage(string $path = '')
    {
        // Check if the path is provided
        if (empty($path)) {
            throw new \Exception('Path is empty');
        }

        // Get all files from the directory
        $files = scandir($path);

        // Filter out the current and parent directory entries
        $files = array_diff($files, ['.', '..']);

        // Check if there are any images in the directory
        if (count($files) === 0) {
            throw new \Exception('No images found');
        }

        // Select a random image file
        $rand = rand(0, count($files) - 1);
        $file = $files[$rand];

        // Load the image, resize it, and encode it in base64 format
        $image = Image::load($path . '/' . $file)
            ->width(600)
            ->height(300)
            ->base64('jpg');

        // Return the filename and the base64 encoded image
        return [$file, $image];
    }

}
