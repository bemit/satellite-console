<?php

namespace Satellite\KernelConsole;

use GetOpt\GetOpt;
use GetOpt\Option;

class Console {
    /**
     * @var array $commands
     */
    protected static $commands = [];

    public static function addCommand($name, \GetOpt\Command $command) {
        static::$commands[$name] = $command;
    }

    /**
     * @param GetOpt $get_opt
     *
     * @return \GetOpt\Command
     * @throws \GetOpt\ArgumentException
     *
     */
    public function process(GetOpt $get_opt): \GetOpt\Command {
        $get_opt->addOption((new Option('h', 'help', Getopt::NO_ARGUMENT))->setDescription('Displays help with all commands.'));

        foreach(static::$commands as $cmd) {
            $get_opt->addCommand($cmd);
        }

        $get_opt->process();// throws: \GetOpt\ArgumentException

        if($get_opt->getOption('h')) {
            echo $get_opt->getHelpText();
            echo 'Show options, arguments and info about one command: ' . PHP_EOL;
            echo '  php cli <command-name> -h ' . PHP_EOL . PHP_EOL;
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
