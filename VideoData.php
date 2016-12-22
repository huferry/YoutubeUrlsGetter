<?php namespace YoutubeUrlsGetter;

include_once('StreamMapParser.php');
include_once('YoutubeStream.php');

class VideoData
{
    private $rawResponse;
    private $json = null;

    public function __construct($rawResponse)
    {
        $this->rawResponse = $rawResponse;
        $this->json = $this->parseJson($rawResponse);
    }

    public function getStreams()
    {        
        $streams = $this->json['args']['url_encoded_fmt_stream_map'].','.
                   $this->json['args']['adaptive_fmts'];

        $result = new YoutubeStreamSet();
        foreach(preg_split('/,/', $streams) as $rawstream)
        {             
            $result->add((new StreamMapParser($rawstream))->getStream());
        }
        return $result;
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