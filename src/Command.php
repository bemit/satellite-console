<?php

namespace Satellite\KernelConsole;

class Command {
    /**
     * @param $name
     * @param $handler
     * @param null $options
     *
     * @return \GetOpt\Command
     */
    public static function create($name, $handler, $options = null) {
        $command = new \GetOpt\Command($name, $handler, $options);

        // here the automatic activation happens
        Console::addCommand($name, $command);

        return $command;
    }
}
