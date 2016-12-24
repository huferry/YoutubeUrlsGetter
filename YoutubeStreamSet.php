<?php namespace YoutubeUrlsGetter;

include_once('YoutubeStream.php');

class YoutubeStreamSet
{
    private $set = [];

    public function add(YoutubeStream $stream)
    {
        $this->set[] = $stream;
    }

    public function isVideo($format = '')
    {
        return $this->copy('typeIsVideo', $format);
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
        $qset = $this->set;
        usort($qset, array($this, 'compareQuality'));
        $newSet = new YoutubeStreamSet();
        $newSet->set = array_values($qset);
        return $newSet;
    }

    private function compareQuality($s1, $s2)
    {
        if ($s1->format->quality == $s2->format->quality)
        {
            return 0;
        }

        return $s1->format->quality > $s2->format->quality ? -1 : 1;
    }

    private function getBest()
    {
        return $this->sortByQuality()->first;
    }

    function __get($p)
    {
        if ($p == 'asArray')
        {
            return $this->set;
        }
        
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

    private function typeIsVideo(YoutubeStream $s, $format)
    {
        return preg_match("/video\/$format.+/", $s->type);
    }

    private function withItag(YoutubeStream $s, $itagNumber)
    {
        return $s->itag == $itagNumber;
    }    
}