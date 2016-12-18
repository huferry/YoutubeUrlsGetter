<?php

use YoutubeUrlsGetter\Extractor;
use YoutubeUrlsGetter\VideoUrl;

include('../Extractor.php');
include('../VideoUrl.php');

$url = new VideoUrl("https://www.youtube.com/watch?v=AufbF07OHi4");
$v = new Extractor($url);

foreach($v->getVideoData()->getStreams() as $s)
{
    print($s->type."\n");
    print($s->url."\n\n");
}