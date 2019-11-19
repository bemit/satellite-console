<?php

namespace Satellite\KernelConsole;

use Psr\EventDispatcher\StoppableEventInterface;
use Satellite\Event\StoppableEvent;

class ConsoleEvent implements StoppableEventInterface {
    use StoppableEvent;

    public $handler;
    public $options;
    public $operands;
}
