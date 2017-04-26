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
use Humbug\Phpunit\Filter\FilterInterface;
use Humbug\Phpunit\Listener\FilterListener;

class FilterListenerTest extends \PHPUnit_Framework_TestCase
{

    private $filter;

    private $suite;

    private $subSuite1;

    private $subSuite2;

    protected function setup()
    {
        $this->filter = m::mock("\\Humbug\Phpunit\\Filter\\FilterInterface");
        $this->suite = m::mock("\\PHPUnit_Framework_TestSuite");
        $this->subSuite1 = m::mock("\\PHPUnit_Framework_TestSuite");
        $this->subSuite2 = m::mock("\\PHPUnit_Framework_TestSuite");

        $this->suite->shouldReceive("getName")->once()->andReturn("Suite1");
        $this->suite->shouldReceive("tests")->once()->andReturn(array($this->subSuite1, $this->subSuite2));

        $this->filter->shouldReceive("filter")->once()
            ->with(array($this->subSuite1, $this->subSuite2))
            ->andReturn(array($this->subSuite2, $this->subSuite1));

        /**
         * The setTests method name is deceptive, it essentially accepts an array of
         * (sub-)TestSuite objects nested into current TestSuite.
         */
        $this->suite->shouldReceive("setTests")->once()->with(array($this->subSuite2, $this->subSuite1));
    }

    public function testShouldFilterSubSuites()
    {
        $listener = new FilterListener(0, $this->filter);
        $listener->startTestSuite($this->suite);


        /**
         * Asset that nesting was reset to root suite
         */
        $this->assertSame(1, $listener->getSuiteLevel());

        $listener->endTestSuite($this->suite);

        $this->assertSame(0, $listener->getSuiteLevel());
    }

}