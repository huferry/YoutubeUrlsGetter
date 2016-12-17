<? namespace YoutubeUrlsGetter;

class Extractor
{
    private $url;

    public function __construct(VideoUrl $url)
    {
        $this->url = $url;
    }

    function __get($p)
    {
        if ($p == "videoId")
        {
            return $this->url->videoId;
        }
    }
}