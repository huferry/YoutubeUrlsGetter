<?php

use PHPUnit\Framework\TestCase;
use YoutubeUrlsGetter\YoutubeStream;
use YoutubeUrlsGetter\YoutubeStreamSet;
use YoutubeUrlsGetter\Format;

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

    public function testIsVideo_withFormatMp4_shouldReturnOnlyMp4()
    {
        $url = "121212121";
        $set = new YoutubeStreamSet();

        $streams = $this->createArray(['video/mp4 bla','video/webm','video/mp4 bla bla', 'video/mp3']);
        $streams[1]->url = $url;
        foreach($streams as $s)
        {
            $set->add($s);
        }

        $result = $set->isVideo('mp4')->asArray;

        $this->assertEquals(2, count($result));
        $this->assertEquals("video/mp4 bla", $result[0]->type);
        $this->assertEquals("video/mp4 bla bla", $result[1]->type);
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
        $s->format = (new Format())->asVideo(360);
        $set->add($s);
        
        $s = new YoutubeStream();
        $s->format = (new Format())->asVideo(1080);
        $set->add($s);

        $s = new YoutubeStream();
        $s->format = (new Format())->asVideo(144);
        $set->add($s);

        $this->assertEquals('1080', $set->best->format->quality);
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
