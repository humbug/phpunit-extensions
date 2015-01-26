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

    public function filter(array $array)
    {
        $times = $this->loadTimes();
        @usort($array, function (\PHPUnit_Framework_TestSuite $a, \PHPUnit_Framework_TestSuite $b) use ($times) {
            $na = $a->getName();
            $nb = $b->getName();
            if (!isset($times['suites'][$na]) || !isset($times['suites'][$nb])) {
                throw new \RuntimeException(
                    'FastestFirstFilter has encountered an unlogged test suite which cannot be sorted'
                );
            }
            if ($times['suites'][$na] == $times['suites'][$nb]) {
                return 0;
            }
            if ($times['suites'][$na] < $times['suites'][$nb]) {
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
