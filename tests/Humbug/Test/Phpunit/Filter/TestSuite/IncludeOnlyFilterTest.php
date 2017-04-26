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
use Mockery as m;
use PHPUnit\Framework\TestCase;

class IncludeOnlyFilterTest extends TestCase
{
    public function testShouldFilterSuitesAndReturnChosenSelection()
    {
        $suite1 = m::mock(['getName' => 'Suite1']);
        $suite2 = m::mock(['getName' => 'Suite2']);
        $suite3 = m::mock(['getName' => 'Suite3']);

        $filter = new IncludeOnlyFilter('Suite1', 'Suite3');

        $return = $filter->filter([$suite1, $suite2, $suite3]);

        $this->assertSame([$suite1, $suite3], $return);
    }
}
