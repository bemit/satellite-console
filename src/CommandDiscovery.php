<?php declare(strict_types=1);

namespace Satellite\KernelConsole;

use Psr\Log\LoggerInterface;

class CommandDiscovery {
    public const CONTAINER_ID = 'commands';

    public function registerAnnotations(\GetOpt\GetOpt $get_opt, \Psr\Container\ContainerInterface $container, LoggerInterface $logger): void {
        $commands = $container->get(self::CONTAINER_ID);
        if(!is_array($commands)) {
            $logger->error(__CLASS__ . ' commands in container entry `' . self::CONTAINER_ID . '` must be array');
            return;
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
    }
}
