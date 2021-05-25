<?php

namespace Mi\Core\Exceptions;

use Mi\Core\Exceptions\BaseException;

/**
 * @method static \Throwable invalidPath()
 */
class FileException extends BaseException
{
    /**
     * Get prefix of code
     *
     * @return string
     */
    protected static function getPrefix()
    {
        return 'file_exception';
    }
}
