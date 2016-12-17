<?php namespace YoutubeUrlsGetter\Tests;

use PHPUnit\Framework\TestCase;
use YoutubeUrlsGetter\VideoUrl;

include '../VideoUrl.php';

class ExtractorTests extends TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructor_urlIsNull_throw()
    {
        new VideoUrl(null);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testConstructor_urlIsNotYoutube_throw()
    {
        $url = "http://google.com";

        new VideoUrl($url);
    }

    public function testConstructor_urlIsYoutube_ShouldHaveSameUrlProperty()
    {
        $url = "https://www.youtube.com/watch?v=iK0gmZrK9k8";

        $videoUrl = new VideoUrl($url);

        $this->assertEquals($url, $videoUrl->url);
    }

    public function testConstructor_urlHasYoutubeVideoId_ShouldHaveSameVideoIdProperty()
    {
        $videoId = "iK0gmZrK9k8";
        $url = "https://www.youtube.com/watch?v=".$videoId;

        $videoUrl = new VideoUrl($url);

        $this->assertEquals($videoId, $videoUrl->videoId);
    }


}

