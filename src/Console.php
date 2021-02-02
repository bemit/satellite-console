<?php

namespace Satellite\KernelConsole;

use GetOpt\GetOpt;
use GetOpt\Option;

class Console {
    /**
     * @var array $commands
     */
    protected static $commands = [];
    protected GetOpt $get_opt;

    public function __construct(GetOpt $get_opt) {
        $this->get_opt = $get_opt;
    }

    public static function addCommand($name, \GetOpt\Command $command) {
        static::$commands[$name] = $command;
    }

    /**
     * @return \GetOpt\Command
     * @throws \GetOpt\ArgumentException
     */
    public function process(): \GetOpt\Command {
        $this->get_opt->addOption((new Option('h', 'help', Getopt::NO_ARGUMENT))->setDescription('Displays help with all commands.'));

        foreach(static::$commands as $cmd) {
            $this->get_opt->addCommand($cmd);
        }

        $this->get_opt->process();// throws: \GetOpt\ArgumentException

        if($this->get_opt->getOption('h')) {
            echo $this->get_opt->getHelpText();
            echo 'Show options, arguments and info about one command: ' . PHP_EOL;
            echo '  php cli <command-name> -h ' . PHP_EOL . PHP_EOL;
            exit;
        }

        $command = $this->get_opt->getCommand();
        if(!$command) {
            // no command
            error_log('Console: no command');
            exit();
        }

        return $command;
    }
}
