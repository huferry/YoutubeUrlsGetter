<?php namespace YoutubeUrlsGetter;

/// Represents a youtube video url
class VideoUrl 
{
    private $url;
    private $videoId;

    function __construct($url)
    {
        $youtubePattern = "/https:\/\/www\.youtube\.com\/.+?v=([A-Z|a-z|0-9|\_]{8,12})/";
        if (preg_match($youtubePattern, $url, $matches))
        {
            $this->url = $url;
            $this->videoId = $matches[1];
            return;
        }
        throw new \InvalidArgumentException("Invalid Youtube URL");
    }

    public function getContent()
    {
        return file_get_contents($this->url);
    }

    function __get($p)
    {
        switch($p)
        {
            case "url":
                return $this->url;
            case "videoId":
                return $this->videoId;
        }
    }
}