<?php

namespace Satellite\KernelConsole;

use Satellite\SystemLaunchEvent;

class CommandDiscovery {

    public $container_id = 'commands';

    public function registerAnnotations(SystemLaunchEvent $exec, \GetOpt\GetOpt $get_opt, \Psr\Container\ContainerInterface $container) {
        // automatic registering of commands discovered by annotations
        if(!$exec->cli) {
            return $exec;
        }

        $commands = $container->get($this->container_id);
        if(!is_array($commands)) {
            return $exec;
        }

        foreach($commands as $command) {
            if(!isset($command['class'], $command['annotation'])) {
                continue;
            }
            $annotation = $command['annotation'];
            if(isset($command['method'])) {
                // If the annotation was targeted at an method, set the method as handler
                $annotation->handler = $command['method'];
            }
            $cmd = CommandBuilder::make($command['class'], $annotation);

            if($cmd) {
                $get_opt->addCommand($cmd);
            }
        }

        return $exec;
    }
}
