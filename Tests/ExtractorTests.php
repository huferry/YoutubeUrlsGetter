<?php namespace YoutubeUrlsGetter\Tests;

use PHPUnit\Framework\TestCase;
use YoutubeUrlsGetter\Extractor;
use YoutubeUrlsGetter\VideoUrl;

include '../Extractor.php';
include '../VideoUrl.php';

class ExtractorTests extends TestCase
{
    public function testConstructor_urlIsValid_shouldReturnSameVideoIdProperty()
    {
        $videoUrl = new VideoUrl("https://www.youtube.com/watch?v=iK0gmZrK9k8");
        $e = new Extractor($videoUrl);

        $this->assertEquals($videoUrl->videoId, $e->videoId);
    }

}
