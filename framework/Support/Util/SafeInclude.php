<?php
namespace Eddy\Framework\Support\Util;

final class SafeInclude
{
    public static function file(string $path)
    {
        return safeInclude($path);
    }
}

function safeInclude(string $path) {
    return include $path;
}
