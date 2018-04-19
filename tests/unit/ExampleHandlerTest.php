<?php

namespace Popcorn4dinner\Commands\Tests;


use PHPUnit\Framework\TestCase;
use Popcorn4dinner\Commands\Examples\ExampleCommand;
use Popcorn4dinner\Commands\Examples\ExampleHandler;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface;

class ExampleHandlerTest extends TestCase
{

    private $logger;

    function setUp()
    {
        parent::setUp();

        $this->logger = $this->createMock(LoggerInterface::class);
    }

    function test_execute_calls_all_expected_methods()
    {
        $handler = new ExampleHandler($this->logger);

        $this->logger
            ->expects($this->once())
            ->method('info')
            ->with('executing ExampleCommand with someParameter=42');

        $command = new ExampleCommand();
        $command->someParameter = 42;

        $this->assertEquals(42, $handler->execute($command));
    }


    /**
     * @expectedException \RuntimeException
     */
    function test_execute_calls_all_expected_methods_whenCommandFails()
    {
        $handler = new ExampleHandler($this->logger);

        $this->logger
            ->expects($this->once())
            ->method('warning')
            ->with('Failed: executing ExampleCommand with someParameter=null');

        $handler->execute(new ExampleCommand());
    }

}
