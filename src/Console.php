<?php

namespace Satellite\KernelConsole;

use GetOpt\GetOpt;
use Satellite\Event;
use Satellite\SystemLaunchEvent;

class Console {
    /**
     * @var array $commands
     */
    protected static $commands = [];

    public static function handle(SystemLaunchEvent $exec) {
        if(!$exec->cli) {
            return $exec;
        }

        $cli = new static();

        $evt = $cli->match();

        if($evt && $evt->handler) {
            Event::dispatch($evt);
        }

        return $exec;
    }

    public static function addCommand($name, \GetOpt\Command $command) {
        static::$commands[$name] = $command;
    }

    /**
     * @throws \GetOpt\ArgumentException
     *
     * @return \Satellite\KernelConsole\ConsoleEvent
     */
    public function match() {
        $get_opt = new GetOpt();

        foreach(static::$commands as $cmd) {
            $get_opt->addCommand($cmd);
        }

        $get_opt->process();// throws: \GetOpt\ArgumentException

        $command = $get_opt->getCommand();
        if(!$command) {
            // no command
            error_log('Console: no command');
            exit();
        }

        // todo: check if `$command` or `get_opt` returns the operands, in the docu it was mixed usage without explanation
        $evt = new ConsoleEvent();
        $evt->handler = $command->getHandler();
        //$evt->options = $get_opt->getOptions();
        $evt->options = $command->getOptions();
        //$evt->operands = $get_opt->getOperands();
        $evt->operands = $command->getOperands();

        return $evt;
    }
}
