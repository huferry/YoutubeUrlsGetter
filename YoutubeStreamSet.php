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

    public function withFormat($itag)
    {
        return $this->copy('withItag', $itag);
    }

    private function copy($funcFilter, $filterArg = null)
    {
        if ($funcFilter == '')
        {
            return $this;
        }

        $newSet = new YoutubeStreamSet();        
        foreach($this->set as $s)
        {
            if (call_user_func(array($this, $funcFilter), $s, $filterArg))
            {
                $newSet->set[] = $s;
            }
        }
        return $newSet;                
    }

    public function any()
    {
        return $this->length > 0;
    }

    public function sortByQuality()
    {
        $newSet = new YoutubeStreamSet();
        $qmap = [];
        foreach($this->set as $s)
        {
            $quality = preg_match('/\d{2,4}/', $s->quality, $match) ? (float)$match[0] : 0.0;
            $qmap[$quality] = $s;
        }
        rsort($qmap);
        $newSet->set = array_values($qmap);
        return $newSet;
    }

    private function getBest()
    {
        return $this->sortByQuality()->first;
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

        if ($p == 'best')
        {
            return $this->getBest();
        }

        if ($p == 'single')
        {
            if ($this->length == 1)
            {
                return $this->set[0];
            }
            throw new \OutOfBoundsException('Set does not have exactly one element.');
        }
    }

    private function typeIsAudio(YoutubeStream $s)
    {
        return preg_match('/audio\/.+/', $s->type);
    }

    private function typeIsVideo(YoutubeStream $s)
    {
        return preg_match('/video\/.+/', $s->type);
    }

    private function withItag(YoutubeStream $s, $itagNumber)
    {
        return $s->itag == $itagNumber;
    }    
}