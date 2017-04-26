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
use Humbug\Phpunit\Filter\TestSuite\FastestFirstFilter;
use PHPUnit\Framework\TestCase;

class FastestFirstFilterTest extends TestCase
{

    protected $timeFile = null;

    protected function setup()
    {
        $tmp = sys_get_temp_dir();
        $this->timeFile = $tmp."/times.json";
        file_put_contents($this->timeFile, "{\"suites\":{\"Suite1\":\"2\",\"Suite2\":\"3\",\"Suite3\":\"1\"}}");
    }

    protected function teardown()
    {
        @unlink($this->timeFile);
    }

    public function testShouldFilterSuitesAndReturnFastestFirst()
    {
        $filter = new FastestFirstFilter($this->timeFile);

        $suite1 = m::mock("\\PHPUnit\\Framework\\TestSuite");
        $suite2 = m::mock("\\PHPUnit\\Framework\\TestSuite");
        $suite3 = m::mock("\\PHPUnit\\Framework\\TestSuite");

        $suite1->shouldReceive("getName")->once()->andReturn("Suite1");
        $suite2->shouldReceive("getName")->once()->andReturn("Suite2");
        $suite3->shouldReceive("getName")->once()->andReturn("Suite3");

        $return = $filter->filter([$suite1, $suite2, $suite3]);

        $this->assertSame(
            [$suite3, $suite1, $suite2],
            $return
        );
    }

}
