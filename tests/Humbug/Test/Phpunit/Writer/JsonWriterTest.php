<?php

use Humbug\Phpunit\Writer\JsonWriter;
use PHPUnit\Framework\TestCase;

class JsonWriterTest extends TestCase
{
    /**
     * @dataProvider jsonWriterWrongArgumentsProvider
     */
    public function testShouldThrowExceptionWhenTargetIsNotSpecified($wrongArgument)
    {
        $this->expectException(InvalidArgumentException::class);

        new JsonWriter($wrongArgument);
    }

    public function jsonWriterWrongArgumentsProvider()
    {
        return [
            [''],
            [[]],
            [null],
            [new stdClass()],
        ];
    }
}
