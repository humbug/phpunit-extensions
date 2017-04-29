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

use Humbug\Phpunit\Filter\TestSuite\IncludeOnlyFilter;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\TestSuite;

class IncludeOnlyFilterTest extends TestCase
{
    public function testShouldFilterSuitesAndReturnChosenSelection()
    {
        $suite1 = $this->createMock(TestSuite::class);
        $suite1->method('getName')->willReturn('Suite1');
        $suite2 = $this->createMock(TestSuite::class);
        $suite2->method('getName')->willReturn('Suite2');
        $suite3 = $this->createMock(TestSuite::class);
        $suite3->method('getName')->willReturn('Suite3');

        $filter = new IncludeOnlyFilter('Suite1', 'Suite3');

        $return = $filter->filter([$suite1, $suite2, $suite3]);

        $this->assertSame([$suite1, $suite3], $return);
    }
}
