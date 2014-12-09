<?php
/**
 * Коршунов Георгий <georgy.k@nevosoft.ru>
 */    

namespace QuickTorrent;

class Episode
{
    public $season;
    public $episode;

    public function __construct($season, $episode)
    {
        $this->season = $season;
        $this->episode = $episode;
    }

    public function __toString()
    {
        return sprintf("s%02de%02d", $this->season, $this->episode);
    }

    public static function fromString($string)
    {
        preg_match('/s(\d{2})e(\d{2})/i', $string, $matches);
        list($fullEpisode, $season, $episode) = $matches;
        return new self($season, $episode);
    }

    public function nextEpisode() 
    {
        return new self($this->season, $this->episode + 1);
    }

    public function nextSeason() 
    {
        return new self($this->season + 1, 1);
    }
}
