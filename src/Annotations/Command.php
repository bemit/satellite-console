<?php

namespace Satellite\KernelConsole\Annotations;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target({"CLASS", "METHOD"})
 */
final class Command {
    /**
     * @var string
     */
    public string $name;
    /**
     * @var string autofilled from discovery when applied to a method
     */
    public string $handler;
    /**
     * @var \Satellite\KernelConsole\Annotations\CommandOption[]
     */
    public array $options = [];
    /**
     * @var \Satellite\KernelConsole\Annotations\CommandOperand[]
     */
    public array $operands = [];
}
