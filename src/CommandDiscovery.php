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
            /**
             * @var \Orbiter\AnnotationsUtil\AnnotationResult $command
             */
            if(!$command->getClass() || !$command->getAnnotation()) {
                continue;
            }
            /**
             * @var \Satellite\KernelConsole\Annotations\Command $annotation
             */
            $annotation = $command->getAnnotation();
            if($command->getMethod()) {
                // If the annotation was targeted at an method, set the method as handler
                $annotation->handler = $command->getMethod();
            }
            $cmd = CommandBuilder::make($command->getClass(), $annotation);

            if($cmd) {
                $get_opt->addCommand($cmd);
            }
        }

        return $exec;
    }
}
