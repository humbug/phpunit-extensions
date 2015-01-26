<?php
/**
 * Humbug
 *
 * @category   Humbug
 * @package    Humbug
 * @copyright  Copyright (c) 2015 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    https://github.com/padraic/humbug/blob/master/LICENSE New BSD License
 */

namespace Humbug\Phpunit\Filter\TestSuite;

class IncludeOnlyFilter extends AbstractFilter
{

    private $exclusivelyInclude;

    public function __construct()
    {
        // check func_num_args?
        $this->exclusivelyInclude = func_get_args();
    }

    public function filter(array $array)
    {
        // clearly will need to revise once multi-root suites are supported
        $return = [];
        foreach ($array as $suite) {
            if (in_array($suite->getName(), $this->exclusivelyInclude)) {
                $return[] = $suite;
            }
        }
        return $return;
    }


}
