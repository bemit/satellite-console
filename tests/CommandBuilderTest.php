<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/mock/CommandMock.php';

final class CommandBuilderTest extends TestCase {
    public function testMakeCommandHandler(): void {
        $annotation = new \Satellite\KernelConsole\Annotations\Command();
        $annotation->name = 'test-name';
        $annotation->handler = 'testHandler';
        $cmd = \Satellite\KernelConsole\CommandBuilder::make(CommandMock::class, $annotation);
        $this->assertEquals(GetOpt\Command::class, get_class($cmd));
        $this->assertEquals('test-name', $cmd->getName());
        $this->assertEquals(false, $cmd->getHandler() === null);
        $this->assertEquals(CommandMock::class, $cmd->getHandler()[0]);
        $this->assertEquals('testHandler', $cmd->getHandler()[1]);
    }
}
