<?php declare(strict_types=1);

namespace Satellite\KernelConsole;

class CommandDiscovery {
    protected Console $console;

    public function __construct(Console $console) {
        $this->console = $console;
    }

    /**
     * @param \Orbiter\AnnotationsUtil\AnnotationResult[] $commands
     * @return void
     */
    public function registerAnnotations(array $commands): void {
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
                $this->console::addCommand($cmd->getName(), $cmd);
            }
        }
    }
}
