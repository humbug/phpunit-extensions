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

    protected $parentSuiteName;

    protected $classSuiteName;

    protected $currentSuiteTime = 0;

    protected $suiteLevel = 0;

    public function __construct(JsonLogger $logger)
    {
        $this->logger = $logger;
    }

    public function startTestSuite(\PHPUnit_Framework_TestSuite $suite)
    {
        $this->suiteLevel++;
        if ($this->suiteLevel == 1) {
            $this->parentSuiteName = $suite->getName();
        } elseif ($this->suiteLevel == 2) {
            $this->classSuiteName = $suite->getName();
        } else {
            // Level 3 are data providers that we'll ignore
        }
    }

    public function endTest(\PHPUnit_Framework_Test $test, $time)
    {
        $this->currentSuiteTime += $time;
        $this->logger->logTest(
            $this->parentSuiteName,
            $this->classSuiteName,
            $test->getName(),
            $time
        );
    }

    public function endTestSuite(\PHPUnit_Framework_TestSuite $suite)
    {
        /**
         * Only log Level 2 test suites, i.e. your actual test classes. Level 1
         * is the parent root suite(s) defined in the XML config and Level 3 are
         * those hosting data provider tests.
         */
        if ($this->suiteLevel !== 2) {
            $this->suiteLevel--;
            return;
        }
        $this->suiteLevel--;
        $this->logger->logTestSuite(
            $this->parentSuiteName
            $suite->getName(),
            $this->currentSuiteTime
        );
    }
}