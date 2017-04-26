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

use Mockery as m;
use Humbug\Phpunit\Logger\JsonLogger;
use LogicException;
use PHPUnit\Framework\TestCase;

class JsonLoggerTest extends TestCase
{
    public function testShouldThrowExceptionWhenTargetIsNotSpecified()
    {
        $this->setExpectedException('\LogicException', 'JsonLogger requires logs target path');
        new \Humbug\Phpunit\Logger\JsonLogger('');
    }

    public function testShouldWriteLogsDuringDestruct()
    {
        $jsonLogger = m::mock("\\Humbug\\Phpunit\\Logger\\JsonLogger")->makePartial();
        $jsonLogger->shouldReceive("write")->once();

        $jsonLogger->__destruct();
    }
}
