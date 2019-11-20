<?php

namespace Satellite\KernelConsole;

use GetOpt\GetOpt;
use GetOpt\Option;
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

        $command = $cli->match();

        $evt = new ConsoleEvent();
        $evt->handler = $command->getHandler();
        $evt->options = $command->getOptions();
        $evt->operands = $command->getOperands();

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
     * @return \GetOpt\Command
     */
    public function match() {
        $get_opt = new GetOpt([(new Option('h', 'help', Getopt::NO_ARGUMENT))->setDescription('Displays help with all commands.')]);

        foreach(static::$commands as $cmd) {
            $get_opt->addCommand($cmd);
        }

        $get_opt->process();// throws: \GetOpt\ArgumentException

        if($get_opt->getOption('h')) {
            echo $get_opt->getHelpText();
            exit;
        }

        $command = $get_opt->getCommand();
        if(!$command) {
            // no command
            error_log('Console: no command');
            exit();
        }

        return $command;
    }
}
