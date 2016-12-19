<?php namespace YoutubeUrlsGetter;

/// Represents a youtube video url
class VideoUrl 
{
    private $url;
    private $videoId;
    private $videoIdPattern = '/[A-Z|a-z|0-9|\_]{8,12}/';
    private $youtubePattern = "/https:\/\/www\.youtube\.com\/.+?v=([A-Z|a-z|0-9|\_]{8,12})/";
    private $youtubeUrl = "https://www.youtube.com/watch?v=";

    /**
    * Create a Youtube Url
    * @param string $videoId Can be the Youtube video URL or only the id of the video. When an 
    *                        URL other than Youtube's URL is given, then an error will be thrown.
    *
    * @example 
    *   <pre>
    *    $url = new VideoUrl('fEx793_X5r'); // using videoId
    *    $url2 = new VideoUrl('https://www.youtube.com/watch?v=fEx793_X5r'); // using complete url
    *   </pre>
    */
    function __construct($videoId)
    {
        if (preg_match($this->youtubePattern, $videoId, $matches))
        {
            $this->url = $videoId;
            $this->videoId = $matches[1];
            return;
        }

        if ($this->isVideoId($videoId))
        {
            $this->url = $this->youtubeUrl.$videoId;
            $this->videoId = $videoId;
            return;
        }
        throw new \InvalidArgumentException("Invalid Youtube URL");
    }

    /**
    * Retrieve the HTML response from the Youtube server.
    * @return HTML response from Youtube.
    */
    public function getContent()
    {
        return file_get_contents($this->url);
    }

    private function isVideoId($id)
    {
        return preg_match($this->videoIdPattern, $id);
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