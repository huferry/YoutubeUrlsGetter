<?php namespace YoutubeUrlsGetter;

class StreamMapParser
{
    private $values = [];

    function __construct($raw)
    {
        $this->values = $this->parseValues($raw);
    }

    public function getUrl()
    {
        if (!array_key_exists('url', $this->values))
        {
            return '';
        }

        return urldecode(urldecode( $this->values['url'].
            $this->copyArg('signature', ['signature', 's', 'sig']).
            $this->copyArg('ratebypass', 'ratebypass').
            $this->copyArg('fallback_host', 'fallback_host')
        ));
    }

    public function getStream()
    {
        $stream = new YoutubeStream();
        $stream->url = $this->getUrl();
        $stream->type = $this->getFirstValue('type');
        $stream->quality = $this->getFirstValue(['quality', 'quality_label']);
        $stream->itag = $this->getFirstValue('itag');
        return $stream;
    }

    private function getFirstValue($valueKeys)
    {
        $arrayValues = is_array($valueKeys) ? $valueKeys : [$valueKeys];

        foreach($arrayValues as $key)
        {
            if (array_key_exists($key, $this->values))
            {
                return $this->values[$key];
            }
        }
        return;        
    }

    private function copyArg($argName, $valueKey)
    {
        $value = $this->getFirstValue($valueKey);
        if ($value != '')
        {
            return "&$argName=$value";
        }
    }

    function parseValues($raw)
    {
        if ($raw == '')
        {
            return [];
        }

        $pairs = preg_split("/\&/", $raw);
        $result = [];
        
        foreach($pairs as $pairraw)
        {
            $pair = preg_split('/=/', $pairraw);
            $result[ urldecode($pair[0]) ] = count($pair)>1 ? urldecode($pair[1]) : '';
        }
        return $result;
    }

    function __get($p)
    {
        if ($p == 'values')
        {
            return $this->values;
        }
    }
}