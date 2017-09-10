<?php
/**
 * Humbug.
 *
 * @category   Humbug
 *
 * @copyright  Copyright (c) 2015 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    https://github.com/padraic/humbug/blob/master/LICENSE New BSD License
 */

namespace Humbug\Phpunit\Logger;

use Humbug\Phpunit\Writer\JsonWriter;

class JsonLogger
{
    /**
     * @var array
     */
    private $suites = [];

    /**
     * @var array
     */
    private $tests = [];

    /**
     * @var JsonWriter
     */
    private $writer;

    public function __construct(JsonWriter $writer)
    {
        $this->writer = $writer;
    }

    public function __destruct()
    {
        $this->write();
    }

    public function logTestSuite($title, $time)
    {
        $this->suites[$title] = $time;
    }

    public function logTest($suite, $title, $time)
    {
        if (!isset($this->tests[$suite])) {
            $this->tests[$suite] = [];
        }
        $this->tests[$suite][] = [
            'title' => $title,
            'time'  => $time,
        ];
    }

    public function write()
    {
        $this->writer->write([
            'suites' => $this->suites,
            'tests'  => $this->tests,
        ]);
    }
}
