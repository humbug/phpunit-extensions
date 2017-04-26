<?php
/**
 * Humbug
 *
 * @category   Humbug
 * @package    Humbug
 * @copyright  Copyright (c) 2017 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    https://github.com/humbug/humbug/blob/master/LICENSE New BSD License
 */

namespace Humbug\Test\Phpunit\Filter\TestSuite;

use Mockery as m;
use Humbug\Phpunit\Filter\TestSuite\IncludeOnlyFilter;

class IncludeOnlyFilterTest extends \PHPUnit_Framework_TestCase
{


    public function testShouldFilterSuitesAndReturnChosenSelection()
    {
        $suite1 = m::mock(array('getName'=>'Suite1'));
        $suite2 = m::mock(array('getName'=>'Suite2'));
        $suite3 = m::mock(array('getName'=>'Suite3'));

        $filter = new IncludeOnlyFilter('Suite1', 'Suite3');

        $return = $filter->filter(array($suite1, $suite2, $suite3));

        $this->assertSame(
            array($suite1, $suite3),
            $return
        );
    }

}