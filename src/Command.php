<?php

namespace Satellite\KernelConsole;

class Command {
    public static function create($name, $handler, $options = null) {
        $command = new \GetOpt\Command($name, $handler, $options);

        // here the automatic activation happens
        Console::addCommand($name, $command);

        return $command;
    }
}
