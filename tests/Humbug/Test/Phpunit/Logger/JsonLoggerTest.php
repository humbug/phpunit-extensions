<?php
/**
 * Humbug
 *
 * @category   Humbug
 * @package    Humbug
 * @copyright  Copyright (c) 2015 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    https://github.com/padraic/humbug/blob/master/LICENSE New BSD License
 *
 * @author rafal.wartalski@gmail.com
 */

namespace Humbug\Test\Phpunit\Logger;

use Mockery as m;
use Humbug\Phpunit\Logger\JsonLogger;

class JsonLoggerTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldThrowExceptionWhenTargetIsNotSpecified()
    {
        $this->setExpectedException('\LogicException', 'JsonLogger requires logs target path');
        new \Humbug\Phpunit\Logger\JsonLogger('');
    }

    public function testShouldWriteLogsDuringDestruct()
    {
        $jsonLogger = m::mock(JsonLogger::class)->makePartial();
        $jsonLogger->shouldReceive("write")->once();

        $jsonLogger->__destruct();
    }
}