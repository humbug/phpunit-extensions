<?php
/**
 * Humbug
 *
 * @category   Humbug
 * @package    Humbug
 * @copyright  Copyright (c) 2017 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    https://github.com/humbug/humbug/blob/master/LICENSE New BSD License
 */

namespace Humbug\Test\Phpunit\Listener;

use Mockery as m;
use Humbug\Phpunit\Logger\JsonLogger;
use Humbug\Phpunit\Listener\TimeCollectorListener;

class TimeCollectorListenerTest extends \PHPUnit_Framework_TestCase
{

    private $logger;

    private $suite;

    private $test1;

    private $test2;

    protected function setup()
    {
        $this->logger = m::mock(JsonLogger::class);
        
        $this->test1 = m::mock("\\PHPUnit_Framework_Test");
        $this->test2 = m::mock("\\PHPUnit_Framework_Test");
        $this->suite = m::mock("\\PHPUnit_Framework_TestSuite");

        $this->suite->shouldReceive("getName")->once()->andReturn("Suite1");
        $this->test1->shouldReceive("getName")->once()->andReturn("Test1");
        $this->logger->shouldReceive("logTest")->once()->with("Suite1", "Test1", m::type("float"));
        $this->test2->shouldReceive("getName")->once()->andReturn("Test2");
        $this->logger->shouldReceive("logTest")->once()->with("Suite1", "Test2", m::type("float"));

        $this->logger->shouldReceive("endTestSuite")->once()->with($this->suite);
        $this->logger->shouldReceive("write")->once();// on destruction
    }

    public function testShouldCollectNamesAndTimesForLogging()
    {
        $listener = new TimeCollectorListener($this->logger);
        $listener->startTestSuite($this->suite);
        $listener->endTest($this->test1, 1.0);
        $listener->endTest($this->test2, 2.0);
        $listener->endTestSuite($this->suite);
    }

}