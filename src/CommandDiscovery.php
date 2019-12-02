<?php

namespace Satellite\KernelConsole;

use Orbiter\AnnotationsUtil\AnnotationsUtil;
use Orbiter\AnnotationsUtil\CodeInfo;
use Satellite\SystemLaunchEvent;

class CommandDiscovery {

    public static function discoverByAnnotation(SystemLaunchEvent $exec, CodeInfo $code_info, \DI\Container $container) {
        // discovering commands by annotations and registering at the di-container
        if(!$exec->cli || $container->has('commands')) {
            // to support caching found commands
            return $exec;
        }
        $annotated = $code_info->getClassNames('services');
        $commands = [];
        foreach($annotated as $annotated_class) {
            // parsing all command annotations and adding them to the `commands` value in container, to register later (see _commands.php)
            $class_annotation = AnnotationsUtil::getClassAnnotation($annotated_class, Annotations\Command::class);
            if($class_annotation) {
                /**
                 * @var Annotations\Command $class_annotation
                 */
                $commands[] = [
                    'class' => $annotated_class,
                    'annotation' => $class_annotation,
                ];
            }
        }

        $annotated_methods = $code_info->getClassMethods('annotations');
        foreach($annotated_methods as $class_name => $annotated_class_methods) {
            $methods = [];
            array_push($methods, ...$annotated_class_methods['public']);
            array_push($methods, ...$annotated_class_methods['static']);
            foreach($methods as $method) {
                $method_annotation = AnnotationsUtil::getMethodAnnotation($class_name, $method, Annotations\Command::class);
                if($method_annotation) {
                    /**
                     * @var Annotations\Command $method_annotation
                     */
                    $commands[] = [
                        'class' => $class_name,
                        'method' => $method,
                        'annotation' => $method_annotation,
                    ];
                }
            }
        }

        $container->set('commands', $commands);

        return $exec;
    }

    public static function registerAnnotations(SystemLaunchEvent $exec, \GetOpt\GetOpt $get_opt, \Psr\Container\ContainerInterface $container) {
        // automatic registering of commands discovered by annotations
        if(!$exec->cli) {
            return $exec;
        }

        $commands = $container->get('commands');
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
