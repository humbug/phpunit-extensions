<?php
/**
 * Humbug
 *
 * @category   Humbug
 * @package    Humbug
 * @copyright  Copyright (c) 2015 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    https://github.com/padraic/humbug/blob/master/LICENSE New BSD License
 */

namespace Humbug\Phpunit\Filter;

interface FilterInterface
{

    /**
     * Filter provided array of test suites
     *
     * @param string $parent   Name of the parent test suite per XML configuration
     * @param array $array     Array of test suite classes to be filtered from parent
     * @return array
     */
    public function filter($parent, array $array);
}
