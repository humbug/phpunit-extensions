<?php
/**
 * Humbug.
 *
 * @category   Humbug
 *
 * @copyright  Copyright (c) 2017 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    https://github.com/humbug/humbug/blob/master/LICENSE New BSD License
 */

namespace Humbug\Test\Phpunit\Filter\TestSuite;

use Humbug\Phpunit\Filter\TestSuite\FastestFirstFilter;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\TestSuite as PHPUnitTestSuite;

class FastestFirstFilterTest extends TestCase
{
    protected $timeFile = null;

    protected function setUp()
    {
        $tmp = sys_get_temp_dir();
        $this->timeFile = $tmp.'/times.json';
        file_put_contents($this->timeFile, '{"suites":{"Suite1":"2","Suite2":"3","Suite3":"1"}}');
    }

    protected function tearDown()
    {
        @unlink($this->timeFile);
    }

    public function testShouldFilterSuitesAndReturnFastestFirst()
    {
        $filter = new FastestFirstFilter($this->timeFile);

        $suite1 = $this->createMock(PHPUnitTestSuite::class);
        $suite1->method('getName')->willReturn('Suite1');

        $suite2 = $this->createMock(PHPUnitTestSuite::class);
        $suite2->method('getName')->willReturn('Suite2');

        $suite3 = $this->createMock(PHPUnitTestSuite::class);
        $suite3->method('getName')->willReturn('Suite3');

        $return = $filter->filter([$suite1, $suite2, $suite3]);

        $this->assertSame([$suite3, $suite1, $suite2], $return);
    }
}
