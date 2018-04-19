<?php

namespace Popcorn4dinner\Commands\Tests;

use PHPUnit\Framework\TestCase;
use Popcorn4dinner\Commands\CommandPopulator;
use Popcorn4dinner\Commands\Examples\ExampleCommand;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\Request;

class CommandPopulatorTest extends TestCase
{
    private $request;
    private $populator;

    function setUp()
    {
        parent::setUp();

        $this->populator = new CommandPopulator();

        $this->request = $this->createMock(Request::class);
        $this->request->files = $this->createMock(FileBag::class);
    }

    function test_populate_withRequestRespectingConvention()
    {
        $this->request->expects($this->any())
            ->method('get')
            ->with('some_parameter')
            ->will($this->returnValue('works!'));

        $this->request->files->expects($this->any())
            ->method('has')
            ->will($this->returnValue(false));

        $command = $this->populator->populate(new ExampleCommand(), $this->request);

        $this->assertEquals('works!', $command->someParameter);
    }

    function test_populate_withRequestRespectingConvention_withFiles()
    {
        $this->request->expects($this->any())
            ->method('get')
            ->with('some_parameter')
            ->will($this->returnValue('works!'));

        $this->request->files->expects($this->any())
            ->method('has')
            ->will($this->returnValue(true));

        $this->request->files->expects($this->any())
            ->method('get')
            ->will($this->returnValue('fileData'));

        $command = $this->populator->populate(new ExampleCommand(), $this->request);

        $this->assertEquals('fileData', $command->someParameter);
    }

    function test_populate_withRequestNotPresentParameter()
    {
        $this->request->expects($this->any())
            ->method('get')
            ->with('some_parameter')
            ->will($this->returnValue(null));

        $command = $this->populator->populate(new ExampleCommand(), $this->request);

        $this->assertNull($command->someParameter);
    }
}
