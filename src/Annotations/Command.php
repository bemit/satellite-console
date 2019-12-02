<?php

namespace Satellite\KernelConsole\Annotations;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 */
final class Command {
    public $name;
    public $handler;
    /**
     * @var \Satellite\KernelConsole\Annotations\CommandOption[]
     */
    public $options = [];
    /**
     * @var \Satellite\KernelConsole\Annotations\CommandOperand[]
     */
    public $operands = [];
}
