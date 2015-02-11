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

class JsonLoggerTest extends \PHPUnit_Framework_TestCase
{
    public function testShouldThrowExceptionWhenTargetIsNotSpecified()
    {
        $this->setExpectedException('\LogicException', 'JsonLogger requires logs target path');
        new \Humbug\Phpunit\Logger\JsonLogger('');
    }

    public function testShouldWriteLogsDuringDestruct()
    {
        $jsonLogger = $this->getMock('\Humbug\Phpunit\Logger\JsonLogger', ['write'], ['/target/path']);

        $jsonLogger->expects($this->once())->method('write');

        $jsonLogger->__destruct();
    }
}