<?php namespace YoutubeUrlsGetter;

class Format
{
    public $type = "";

    public $quality = 0;

    public function asVideo($quality)
    {
        $this->quality = $quality;
        $this->type = "video";
        return $this;
    }

    public function asAudio($quality)
    {
        $this->type = "audio";
        $this->quality = $quality;
        return $this;
    }

    public static function GetMap()
    { 
        $map = array
        (   5 => (new Format())->asVideo(240),
            6 => (new Format())->asVideo(270),
            13 => (new Format())->asVideo(0),
            17 => (new Format())->asVideo(144),
            18 => (new Format())->asVideo(360),
            22 => (new Format())->asVideo(270),
            34 => (new Format())->asVideo(360),
            35 => (new Format())->asVideo(480),
            36 => (new Format())->asVideo(240),
            37 => (new Format())->asVideo(1080),
            38 => (new Format())->asVideo(3072),
            43 => (new Format())->asVideo(360),
            44 => (new Format())->asVideo(480),
            45 => (new Format())->asVideo(480),
            46 => (new Format())->asVideo(1080),
            133 => (new Format())->asVideo(240),
            134 => (new Format())->asVideo(360),
            135 => (new Format())->asVideo(480),
            136 => (new Format())->asVideo(720),
            137 => (new Format())->asVideo(1080),
            138 => (new Format())->asVideo(2160),
            160 => (new Format())->asVideo(144),
            264 => (new Format())->asVideo(1440),
            298 => (new Format())->asVideo(720),
            299 => (new Format())->asVideo(1080),
            266 => (new Format())->asVideo(2160),
            139 => (new Format())->asAudio(48),
            140 => (new Format())->asAudio(128),
            141 => (new Format())->asAudio(256),
            167 => (new Format())->asVideo(360),
            168 => (new Format())->asVideo(480),
            169 => (new Format())->asVideo(720),
            170 => (new Format())->asVideo(1080),
            218 => (new Format())->asVideo(480),
            219 => (new Format())->asVideo(480),
            242 => (new Format())->asVideo(240),
            243 => (new Format())->asVideo(360),
            244 => (new Format())->asVideo(480),
            245 => (new Format())->asVideo(480),
            246 => (new Format())->asVideo(480),
            247 => (new Format())->asVideo(720),
            248 => (new Format())->asVideo(1080),
            271 => (new Format())->asVideo(1440),
            272 => (new Format())->asVideo(2160),
            302 => (new Format())->asVideo(2160),
            303 => (new Format())->asVideo(1080),
            308 => (new Format())->asVideo(1440),
            313 => (new Format())->asVideo(2160),
            315 => (new Format())->asVideo(2160),
            171 => (new Format())->asAudio(128),
            172 => (new Format())->asAudio(256)
        );
        return $map;
    }

}

