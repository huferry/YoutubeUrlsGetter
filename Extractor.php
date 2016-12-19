<?php namespace YoutubeUrlsGetter;

include_once('VideoData.php');

class Extractor
{
    private $videoUrl;

    /**
    * Create a Youtube stream URLs extractor.
    * @param VideoUrl $videoUrl The Youtube video URL object.
    * @example
    * <pre>
    *   $ext = new Extractor(new VideoUrl('5tXi0'));
    *
    *   // getting video data
    *   $videoData = $ext->getVideoData();
    *
    *   // getting video streams
    *   $streams = $videoData->getStreams(); // array of YoutubeStream objects
    * </pre>
    */
    public function __construct(VideoUrl $videoUrl)
    {
        $this->videoUrl = $videoUrl;
    }

    public function getVideoData()
    {
        return new VideoData($this->videoUrl->getContent());        
    }
}