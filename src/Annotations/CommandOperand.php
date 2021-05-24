<?php

namespace Satellite\KernelConsole\Annotations;

use Doctrine\Common\Annotations\Annotation;
use GetOpt\GetOpt;
use GetOpt\Operand;

/**
 * @Annotation
 * @Target({"ANNOTATION"})
 */
final class CommandOperand {
    public string $name;
    public int $mode = Operand::OPTIONAL;
    public $description;
    public $default;
    public $validation;
}
