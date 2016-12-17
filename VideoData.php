<?php namespace YoutubeUrlsGetter;

class VideoData
{
    private $rawResponse;
    private $json = null;

    public function __construct($rawResponse)
    {
        $this->rawResponse = $rawResponse;
        $this->json = $this->parseJson($rawResponse);
    }

    private function parseJson($rawResponse)
    {
        if (preg_match("/ytplayer\.config\s*=\s*(\{.+?\});/", $rawResponse, $match)) 
        {
            return json_decode($match[1], true);
        }
        return null;
    }

    function __get($p)
    {
        if ($p=='raw')
        {
            return $this->rawResponse;
        }

        if ($p=='json')
        {
            return $this->json;
        }

        if ($p=='title')
        {
            return $this->json["args"]["title"];
        }
    }

}