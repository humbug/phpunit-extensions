<?php
/**
 * Humbug
 *
 * @category   Humbug
 * @package    Humbug
 * @copyright  Copyright (c) 2015 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    https://github.com/padraic/humbug/blob/master/LICENSE New BSD License
 */

namespace Humbug\Phpunit\Listener;

use Humbug\Phpunit\Logger\JsonLogger;

class TimeCollectorListener extends \PHPUnit_Framework_BaseTestListener
{

    protected $rootSuiteName;

    protected $currentSuiteName;

    protected $currentSuiteTime = 0;

    public function __construct(JsonLogger $logger)
    {
        $this->logger = $logger;
    }

    public function startTestSuite(\PHPUnit_Framework_TestSuite $suite)
    {
        if (!isset($this->rootSuiteName)) {
            $this->rootSuiteName = $suite->getName();
        }
        $this->currentSuiteName = $suite->getName();
    }

    public function endTest(\PHPUnit_Framework_Test $test, $time)
    {
        $this->currentSuiteTime += $time;
        $this->logger->logTest(
            $this->currentSuiteName,
            $test->getName(),
            $time
        );
    }

    public function endTestSuite(\PHPUnit_Framework_TestSuite $suite)
    {
        /**
         * Skip logging of suites which are either:
         *      a) The root suite containing other file level suites; or
         *      b) End in ::testName which signify a data provider suite that
         *          will already be getting logged by its parent suite.
         */
        if (preg_match("%\\:\\:[[:alnum:]]+$%", $suite->getName())
        || $this->rootSuiteName == $suite->getName()) {
            return;
        }
        $this->logger->logTestSuite(
            $suite->getName(),
            $this->currentSuiteTime
        );
    }
}