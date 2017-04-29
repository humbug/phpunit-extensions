<?php

namespace Humbug\Phpunit\Writer;

use InvalidArgumentException;

class JsonWriter
{
    /**
     * @var string
     */
    private $target;

    /**
     * @param string $target
     */
    public function __construct($target)
    {
        if (!is_string($target) or empty($target)) {
            throw new InvalidArgumentException('JsonWriter requires logs target path');
        }

        $this->target = $target;
    }

    /**
     * @param mixed $data
     */
    public function write($data)
    {
        file_put_contents($this->target, json_encode($data, JSON_PRETTY_PRINT));
    }
}
