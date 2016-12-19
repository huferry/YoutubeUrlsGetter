<?php 

use PHPUnit\Framework\TestCase;
use YoutubeUrlsGetter\StreamMapParser;
use YoutubeUrlsGetter\VideoData;

class StreamMapParserTest extends TestCase
{
    public function testParse_rawIsEmpty_shouldHaveVeluesEmpty()
    {
        $parser = new StreamMapParser('');

        $this->assertEmpty($parser->values);
    }

    public function testParse_rawHasOnlyKey_shouldHaveVeluesWithKey()
    {
        $parser = new StreamMapParser('key');

        $this->assertArrayHasKey('key', $parser->values);
    }

    public function testParse_rawHasOnlyKeyValue_shouldHaveSameVelue()
    {
        $parser = new StreamMapParser('key=value');

        $this->assertEquals('value', $parser->values['key']);
    }

    public function testParse_rawHasTwoPairs_shouldHaveSecondPair()
    {
        $parser = new StreamMapParser('key=value&title=Gone with the wind');

        $this->assertEquals('Gone with the wind', $parser->values['title']);
    }

    public function testParse_rawHasKeyInUrlEncoded_shouldKeyInUrlDecoded()
    {
        $key = 'XX$#$#myKey';
        $parser = new StreamMapParser(urlencode($key));

        $this->assertArrayHasKey($key, $parser->values);
    }

    public function testParse_rawHasValueInUrlEncoded_shouldHavValueInUrlDecoded()
    {
        $key = 'myKey';
        $value = '$Q#dsfdsf$%$';
        $parser = new StreamMapParser($key.'='.urlencode($value));

        $this->assertEquals($value, $parser->values[$key]);
    }

    public function testGetUrl_rawHasNoSOrSigKeyOrUrlKey_shouldReturnEmpty()
    {
        $parser = new StreamMapParser('test=true');

        $this->assertEquals('', $parser->getUrl());
    }
    
    public function testGetUrl_rawHasUrlKey_shouldReturnUrl()
    {
        $url = 'testurl.testurl';
        $parser = new StreamMapParser('url='.$url);

        $this->assertEquals($url, $parser->getUrl());
    }

    public function testGetUrl_rawHasUrlKeyAndSignature_shouldReturnUrlWithSignature()
    {
        $url = 'testurl.testurl';
        $signature = "5iGn4TuRe";
        $parser = new StreamMapParser("url=$url&s=$signature");

        $this->assertEquals("$url&signature=$signature", $parser->getUrl());
    }

    public function testGetUrl_rawHasUrlKeyAndSig_shouldReturnUrlWithSignature()
    {
        $url = 'testurl.testurl';
        $signature = "5iGn4TuRe";
        $parser = new StreamMapParser("url=$url&sig=$signature");

        $this->assertEquals("$url&signature=$signature", $parser->getUrl());
    }

    public function testGetUrl_rawHasUrlKeyAndSAndSig_shouldReturnUrlWithSignatureEqualsToS()
    {
        $url = 'testurl.testurl';
        $signature = "5iGn4TuRe";
        $parser = new StreamMapParser("url=$url&sig=InvalidSig&s=$signature");

        $this->assertEquals("$url&signature=$signature", $parser->getUrl());
    }

    public function testGetUrl_rawHasUrlKeyAndSignature_shouldReturnUrlWithSignatureEqualsToSignature()
    {
        $url = 'testurl.testurl';
        $signature = "5iGn4TuRe";
        $parser = new StreamMapParser("url=$url&sig=InvalidSig&signature=$signature");

        $this->assertEquals("$url&signature=$signature", $parser->getUrl());
    }

    public function testGetUrl_rawHasFallbackHost_shouldReturnUrlWithFallbackHost()
    {
        $url = 'testurl.testurl';
        $signature = "5iGn4TuRe";
        $fbhost = "FallB4cKH0sT";
        $parser = new StreamMapParser("fallback_host=$fbhost&url=$url&sig=$signature");

        $this->assertEquals("$url&signature=$signature&fallback_host=$fbhost", $parser->getUrl());
    }

    public function testGetUrl_rawHasRateBypass_shouldReturnUrlWithRateBypass()
    {
        $url = 'testurl.testurl';
        $key = 'ratebypass';
        $value = 'yes';
        $parser = new StreamMapParser("url=$url&$key=$value");

        $this->assertEquals("$url&$key=$value", $parser->getUrl());
    }
}