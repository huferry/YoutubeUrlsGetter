<?php namespace YoutubeUrlsGetter;

include_once('YoutubeStream.php');

class YoutubeStreamSet
{
    private $set = [];

    public function add(YoutubeStream $stream)
    {
        $this->set[] = $stream;
    }

    public function isVideo()
    {
        $newSet = new YoutubeStreamSet();
        foreach($this->set as $s)
        {
            if (preg_match('/video\/.+/', $s->type))
            {
                $newSet->add($s);
            }
        }
        return $newSet;
    }

    public function isAudio()
    {
        $newSet = new YoutubeStreamSet();
        foreach($this->set as $s)
        {
            if (preg_match('/audio\/.+/', $s->type))
            {
                $newSet->add($s);
            }
        }
        return $newSet;        
    }

    public function any()
    {
        return $this->length > 0;
    }

    function __get($p)
    {
        if ($p == 'length')
        {
            return count($this->set);
        }

        if ($p == 'first')
        {
            if ($this->length > 0)
            {
                return $this->set[0];
            }
        }
    }
}