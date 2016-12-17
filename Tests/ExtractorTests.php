<?php

use PHPUnit\Framework\TestCase;

include '../Extractor.php';

class ExtractorTests extends TestCase
{

    /**
     * @expectedException InvalidArgumentException
     */
    public function testConstructor_urlIsNull_shouldThrow()
    {
        $e = new Extractor('abc');
    }

}
