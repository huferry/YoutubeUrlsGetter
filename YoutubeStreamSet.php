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
        return $this->copy('typeIsVideo');
    }

    public function isAudio()
    {
        return $this->copy('typeIsAudio');
    }

    private function copy($funcFilter)
    {
        $newSet = new YoutubeStreamSet();        
        foreach($this->set as $s)
        {
            if (call_user_func(array($this, $funcFilter), $s))
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

    private function typeIsAudio(YoutubeStream $s)
    {
        return preg_match('/audio\/.+/', $s->type);
    }

    private function typeIsVideo(YoutubeStream $s)
    {
        return preg_match('/video\/.+/', $s->type);
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