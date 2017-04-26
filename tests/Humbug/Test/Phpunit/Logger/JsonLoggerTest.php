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
use LogicException;
use Mockery as m;
use PHPUnit\Framework\TestCase;

class JsonLoggerTest extends TestCase
{
    public function testShouldThrowExceptionWhenTargetIsNotSpecified()
    {
        $this->expectException(LogicException::class, 'JsonLogger requires logs target path');
        
        new JsonLogger('');
    }

    public function testShouldWriteLogsDuringDestruct()
    {
        $jsonLogger = m::mock(JsonLogger::class)->makePartial();
        $jsonLogger->shouldReceive("write")->once();

        $jsonLogger->__destruct();
    }
}
