<?php

use PHPUnit\Framework\TestCase;
use YoutubeUrlsGetter\VideoData;
use YoutubeUrlsGetter\VideoUrl;

//include 'VideoData.php';

class VideoDataTest extends TestCase
{

    function testConstructor_content_shouldHaveSameRaw()
    {
        $content = file_get_contents('Tests/data/wwwdata.txt');

        $vd = new VideoData($content);

        $this->assertEquals($content, $vd->raw);
    }

    function testConstructor_withInvalidContent_shouldHaveNullObject()
    {
        $vd = new VideoData("invalid");

        $this->assertNull($vd->json);            
    }

    function testConstructor_withValidContent_shouldHaveNotNullObjectProp()
    {
        $content = file_get_contents('Tests/data/wwwdata.txt');

        $vd = new VideoData($content);

        $this->assertNotNull($vd->json);
    }

    function testConstructor_withValidContent_shouldHaveSameTitleProp()
    {
        $content = file_get_contents('Tests/data/wwwdata.txt');

        $vd = new VideoData($content);

        $this->assertEquals($vd->title, 'Rosi & Kandidat Pemimpin Jakarta (Bag. 2)');
    }

    function testGetStreams_withXStreams_shouldReturnsXStreams()
    {
        $content = file_get_contents('Tests/data/wwwdata.txt');

        $vd = new VideoData($content);

        $this->assertCount(17, $vd->getStreams());
    }

}