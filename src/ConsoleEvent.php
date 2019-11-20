<?php

namespace Satellite\KernelConsole;

use Psr\EventDispatcher\StoppableEventInterface;
use Satellite\Event\StoppableEvent;

class ConsoleEvent implements StoppableEventInterface {
    use StoppableEvent;

    /**
     * @var string
     */
    public $handler;
    /**
     * @var array
     */
    public $options;
    /**
     * @var array
     */
    public $operands;
}
