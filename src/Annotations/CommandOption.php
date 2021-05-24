<?php

namespace Satellite\KernelConsole\Annotations;

use Doctrine\Common\Annotations\Annotation;
use GetOpt\GetOpt;

/**
 * @Annotation
 * @Target({"ANNOTATION"})
 */
final class CommandOption {
    public ?string $short = null;
    public ?string $long = null;
    public string $mode = GetOpt::NO_ARGUMENT;
    public $default;
    public $description;
    public $validation;
}
