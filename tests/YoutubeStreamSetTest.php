<?php

use PHPUnit\Framework\TestCase;
use YoutubeUrlsGetter\YoutubeStream;
use YoutubeUrlsGetter\YoutubeStreamSet;

class YoutubeStreamSetTest extends TestCase
{
    public function testAny_withEmpty_shouldReturnFalse()
    {
        $set = new YoutubeStreamSet();

        $this->assertFalse($set->any());
    }

    public function testAny_withOneStream_shouldReturnAnyTrue()
    {
        $set = new YoutubeStreamSet();
        $set->add(new YoutubeStream());

        $this->assertTrue($set->any());
    }

    public function testIsVideo_withVideoStream_shouldReturnAllVideo()
    {
        $set = new YoutubeStreamSet();

        $streams = $this->createArray(['video/mp4','video/webm','video/3gpp', 'audio/mp3']);
        foreach($streams as $s)
        {
            $set->add($s);
        }

        $this->assertEquals(3, $set->isVideo()->length);
    }

    public function testIsAudio_withAudioStream_shouldReturnAllAudio()
    {
        $set = new YoutubeStreamSet();

        $streams = $this->createArray(['audio/mp4','video/webm','video/3gpp', 'audio/mp3']);
        foreach($streams as $s)
        {
            $set->add($s);
        }

        $this->assertEquals(2, $set->isAudio()->length);
    }

    public function testFirst_withStreams_shouldReturnFirst()
    {
        $url = "121212121";
        $set = new YoutubeStreamSet();

        $streams = $this->createArray(['audio/mp4','video/webm','video/3gpp', 'audio/mp3']);
        $streams[1]->url = $url;
        foreach($streams as $s)
        {
            $set->add($s);
        }

        $this->assertEquals($url, $set->isVideo()->first->url);
    }

    public function testWithFormat_withItag_shouldReturnFirstWithSameItag()
    {
        $set = new YoutubeStreamSet();

        $s = new YoutubeStream();
        $s->itag = '335';
        $set->add($s);
        
        $this->assertEquals($s->itag, $set->withFormat(335)->single->itag);
    }

    public function testBest_withQuality_shouldReturnWithBestQuality()
    {
        $set = new YoutubeStreamSet();

        $s = new YoutubeStream();
        $s->quality = '350p';
        $set->add($s);
        
        $s = new YoutubeStream();
        $s->quality = 'hd1080';
        $set->add($s);

        $s = new YoutubeStream();
        $s->quality = '128p';
        $set->add($s);

        $this->assertEquals('hd1080', $set->best->quality);
    }

    private function createArray($types)
    {
        $result = [];
        foreach($types as $t)
        {
            $stream = new YoutubeStream();
            $stream->type = $t;
            $result[] = $stream;
        }
        return $result;
    }

}
