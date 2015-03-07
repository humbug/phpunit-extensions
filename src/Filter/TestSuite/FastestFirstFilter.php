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

class FastestFirstFilter extends AbstractFilter
{

    private $log;

    public function __construct($log)
    {
        $this->log = $log;
    }

    /**
     * Filter provided array of test suites
     *
     * @param string $parent   Name of the parent test suite per XML configuration
     * @param array $array     Array of test suite classes to be filtered from parent
     * @return array
     */
    public function filter($parent, array $array)
    {
        $times = $this->loadTimes();
        @usort($array, function (\PHPUnit_Framework_TestSuite $a, \PHPUnit_Framework_TestSuite $b) use ($times) {
            $na = $a->getName();
            $nb = $b->getName();
            if (!isset($times[$parent]['suites'][$na])) {
                throw new \RuntimeException(sprintf(
                    'FastestFirstFilter has encountered an unlogged test suite which cannot be sorted being %s in "%s" test suite',
                    $na,
                    $parent
                ));
            }
            if (!isset($times[$parent]['suites'][$nb])) {
                throw new \RuntimeException(sprintf(
                    'FastestFirstFilter has encountered an unlogged test suite which cannot be sorted being %s in "%s" test suite',
                    $nb,
                    $parent
                ));
            }

            if ($times[$parent]['suites'][$na] == $times[$parent]['suites'][$nb]) {
                return 0;
            }
            if ($times[$parent]['suites'][$na] < $times[$parent]['suites'][$nb]) {
                return -1;
            }
            return 1;
        });

        return $array;
    }

    private function loadTimes()
    {
        if (!file_exists($this->log)) {
            throw new \Exception(sprintf(
                'Log file for collected times does not exist: %s. '
                . 'Use the Humbug\Phpunit\Listener\TimeCollectorListener listener prior '
                . 'to using the FastestFirstFilter filter at least once',
                $this->log
            ));
        }
        return json_decode(file_get_contents($this->log), true);
    }
}
