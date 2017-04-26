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

use Exception;
use Humbug\Phpunit\Filter\FilterInterface;
use Humbug\Phpunit\Filter\TestSuite\AbstractFilter as TestSuiteFilter;
use PHPUnit\Framework\BaseTestListener;
use PHPUnit\Framework\TestSuite;

class FilterListener extends BaseTestListener
{
    protected $rootSuiteName;

    protected $currentSuiteName;

    protected $suiteFilters = [];

    protected $suiteLevel = 0;

    /**
     * @var int
     */
    protected $rootSuiteNestingLevel;

    public function __construct($rootSuiteNestingLevel)
    {
        $this->rootSuiteNestingLevel = $rootSuiteNestingLevel;
        $args = func_get_args();
        array_shift($args);
        if (empty($args)) {
            throw new Exception(sprintf(
                'No %s objects assigned to FilterListener',
                FilterInterface::class
            ));
        }
        foreach ($args as $filter) {
            $this->addFilter($filter);
        }
    }

    public function startTestSuite(TestSuite $suite)
    {
        $this->suiteLevel++;
        $this->currentSuiteName = $suite->getName();
        if ($this->suiteLevel == (1 + $this->rootSuiteNestingLevel)) {
            $this->rootSuiteName = $suite->getName();
            $suites = $suite->tests();
            $filtered = $this->filterSuites($suites);
            $suite->setTests($filtered);
        }
    }

    public function endTestSuite(TestSuite $suite)
    {
        $this->suiteLevel--;
    }

    public function getSuiteLevel()
    {
        return $this->suiteLevel;
    }

    protected function filterSuites(array $suites)
    {
        $filtered = $suites;
        foreach ($this->suiteFilters as $filter) {
            $filtered = $filter->filter($filtered);
        }
        return $filtered;
    }

    protected function addFilter(FilterInterface $filter)
    {
        if ($filter instanceof TestSuiteFilter) {
            $this->suiteFilters[] = $filter;
        }
    }

}
