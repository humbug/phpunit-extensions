<?php
/**
 * Humbug.
 *
 * @category   Humbug
 *
 * @copyright  Copyright (c) 2017 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    https://github.com/humbug/humbug/blob/master/LICENSE New BSD License
 */

namespace Humbug\Test\Phpunit\Listener;

use Humbug\Phpunit\Listener\TimeCollectorListener;
use Humbug\Phpunit\Logger\JsonLogger;
use Humbug\Phpunit\Writer\JsonWriter;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\TestSuite;

class TimeCollectorListenerTest extends TestCase
{
    /**
     * @var JsonWriter
     */
    private $writer;

    /**
     * @var TestSuite
     */
    private $suite;

    /**
     * @var TestCase
     */
    private $test1;

    /**
     * @var TestCase
     */
    private $test2;

    protected function setUp()
    {
        $this->writer = $this->createMock(JsonWriter::class);
        $this->writer->expects($this->once())->method('write'); // on destruction

        $this->test1 = $this->createMock(TestCase::class);
        $this->test1->expects($this->once())->method('getName')->willReturn('Test1');

        $this->test2 = $this->createMock(TestCase::class);
        $this->test2->expects($this->once())->method('getName')->willReturn('Test2');

        $this->suite = $this->createMock(TestSuite::class);
        $this->suite->method('getName')->willReturn('Suite1');
    }

    public function testShouldCollectNamesAndTimesForLogging()
    {
        $listener = new TimeCollectorListener(new JsonLogger($this->writer));
        $listener->startTestSuite($this->suite);
        $listener->endTest($this->test1, 1.0);
        $listener->endTest($this->test2, 2.0);
        $listener->endTestSuite($this->suite);
    }
}
