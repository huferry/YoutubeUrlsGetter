<?php

use YoutubeUrlsGetter\Extractor;
use YoutubeUrlsGetter\VideoUrl;

include('autoload.php');

$url = new VideoUrl("ecIWPzGEbFc");// "https://www.youtube.com/watch?v=ecIWPzGEbFc");
$v = new Extractor($url);

foreach($v->getVideoData()->getStreams()->asArray as $s)
{
    print("$s->type [$s->quality] Format: $s->itag\n");
    print($s->url."\n\n");
}
print($v->getVideoData()->title);