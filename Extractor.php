<?
class Extractor
{
    public function __construct($url)
    {
        echo('test');
        throw new InvalidArgumentException();
    }
}