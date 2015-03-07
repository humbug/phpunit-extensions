<?php
/**
 * Humbug
 *
 * @category   Humbug
 * @package    Humbug
 * @copyright  Copyright (c) 2015 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    https://github.com/padraic/humbug/blob/master/LICENSE New BSD License
 */

namespace Humbug\Phpunit\Logger;

class JsonLogger
{
    private $suites = [];

    private $tests = [];

    private $target;

    public function __construct($target)
    {
        if (!$target) {
            throw new \LogicException('JsonLogger requires logs target path');
        }
        $this->target = $target;
    }

    public function __destruct()
    {
        $this->write();
    }

    public function logTestSuite($parent, $title, $time)
    {
        if (!isset($this->suites[$parent])) {
            $this->suites[$parent] = [];
        }
        $this->suites[$parent][$title] = $time;
    }

    public function logTest($parent, $suite, $title, $time)
    {
        if (!isset($this->tests[$parent])) {
            $this->tests[$parent] = [];
        }
        if (!isset($this->tests[$parent][$suite])) {
            $this->tests[$parent][$suite] = [];
        }
        $this->tests[$parent][$suite][] = [
            'title' => $title,
            'time' => $time
        ];
    }

    public function write()
    {
        file_put_contents(
            $this->target,
            json_encode(
                [
                    'suites' => $this->suites,
                    'tests' => $this->tests
                ],
                JSON_PRETTY_PRINT
            )
        );
    }
}
