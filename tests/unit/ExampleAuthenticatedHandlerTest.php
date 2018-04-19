<?php

namespace Popcorn4dinner\Commands\Tests;

use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Popcorn4dinner\Commands\Examples\ExampleAuthenticatedHandler;
use Popcorn4dinner\Commands\Examples\ExampleCommand;
use Popcorn4dinner\Commands\Examples\ExampleHandler;
use Symfony\Component\HttpFoundation\Request;

class ExampleAuthenticatedHandlerTest extends TestCase
{

    private $logger;

    function setUp()
    {
        parent::setUp();

        $this->logger = $this->createMock(LoggerInterface::class);
    }

    function test_execute_calls_all_expected_methods()
    {
        $handler = new ExampleAuthenticatedHandler($this->logger);

        $this->logger
            ->expects($this->once())
            ->method('info')
            ->with('somebody is executing ExampleCommand with someParameter=42');

        $command = new ExampleCommand();
        $command->someParameter = 42;

        $this->assertEquals(42, $handler->execute($command));
    }


    /**
     * @expectedException \RuntimeException
     */
    function test_execute_calls_all_expected_methods_whenCommandFails()
    {
        $handler = new ExampleAuthenticatedHandler($this->logger);

        $this->logger
            ->expects($this->once())
            ->method('warning')
            ->with('Failed: somebody tryed executing ExampleCommand with someParameter=null');

        $handler->execute(new ExampleCommand());
    }

}
