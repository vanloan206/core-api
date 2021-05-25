<?php

namespace Mi\Core\Concerns\File;

class File
{
    public static function makeDefaultImageAttributes($attributes = [])
    {
        return array_merge([
            'name' => null,
            'type' => null,
            'mime_type' => null,
            'width' => null,
            'height' => null,
            'original_path' => null,
        ], $attributes);
    }
}
