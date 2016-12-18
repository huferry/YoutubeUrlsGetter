<?php namespace YoutubeUrlsGetter;

include_once('VideoData.php');

class Extractor
{
    private $videoUrl;

    public function __construct(VideoUrl $videoUrl)
    {
        $this->videoUrl = $videoUrl;
    }

    public function getVideoData()
    {
        return new VideoData($this->videoUrl->getContent());        
    }

    function __get($p)
    {
        if ($p == "videoId")
        {
            return $this->videoUrlurl->videoId;
        }
    }
}