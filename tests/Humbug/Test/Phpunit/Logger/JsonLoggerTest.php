<?php
/**
 * Humbug.
 *
 * @category   Humbug
 *
 * @copyright  Copyright (c) 2015 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    https://github.com/padraic/humbug/blob/master/LICENSE New BSD License
 * @author rafal.wartalski@gmail.com
 */

namespace Humbug\Test\Phpunit\Logger;

use Humbug\Phpunit\Logger\JsonLogger;
use Humbug\Phpunit\Writer\JsonWriter;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class JsonLoggerTest extends TestCase
{
    /**
     * @var JsonWriter
     */
    private $writer;

    public function setUp()
    {
        $this->writer = $this->createMock(JsonWriter::class);
    }

    public function testShouldWriteLogsDuringDestruct()
    {
        $this->writer->expects($this->once())->method('write');

        new JsonLogger($this->writer);
    }
}
