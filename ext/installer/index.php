<?php

use Eddy\Framework\Installer\ConsoleInput;
use Eddy\Framework\Installer\Install;

require 'vendor/autoload.php';

$i = ConsoleInput::fetch();

$name = $i->getArgument('name');

Install::fresh($name);
