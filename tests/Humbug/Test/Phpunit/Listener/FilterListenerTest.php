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

use Humbug\Phpunit\Filter\FilterInterface;
use Humbug\Phpunit\Listener\FilterListener;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\TestSuite;

class FilterListenerTest extends TestCase
{
    private $filter;

    private $suite;

    private $subSuite1;

    private $subSuite2;

    protected function setUp()
    {
        $this->filter = $this->createMock(FilterInterface::class);
        $this->suite = $this->createMock(TestSuite::class);
        $this->subSuite1 = $this->createMock(TestSuite::class);
        $this->subSuite2 = $this->createMock(TestSuite::class);

        $this->suite->expects($this->atLeast(1))->method('getName')->willReturn('Suite1');
        $this->suite->expects($this->once())->method('tests')->willReturn([$this->subSuite1, $this->subSuite2]);

        $this->filter->expects($this->once())->method('filter')
            ->with([$this->subSuite1, $this->subSuite2])
            ->willReturn([$this->subSuite2, $this->subSuite1]);

        /*
         * The setTests method name is deceptive, it essentially accepts an array of
         * (sub-)TestSuite objects nested into current TestSuite.
         */
        $this->suite->expects($this->once())->method('setTests')->with([$this->subSuite2, $this->subSuite1]);
    }

    public function testShouldFilterSubSuites()
    {
        $listener = new FilterListener(0, $this->filter);
        $listener->startTestSuite($this->suite);

        /*
         * Asset that nesting was reset to root suite
         */
        $this->assertSame(1, $listener->getSuiteLevel());

        $listener->endTestSuite($this->suite);

        $this->assertSame(0, $listener->getSuiteLevel());
    }
}
