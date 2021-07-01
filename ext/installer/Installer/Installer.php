<?php
namespace Eddy\Framework\Installer;

use Symfony\Component\Filesystem\Filesystem;

class Installer
{
    public function __construct(private Filesystem $fs)
    {}
}
