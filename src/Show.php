<?php
/**
 * Коршунов Георгий <georgy.k@nevosoft.ru>
 */    

namespace QuickTorrent;

class Show implements \JsonSerializable
{
    public $name;
    public $lastEpisode;

    public function __construct($name, $lastEpisode)
    {
        $this->name = $name;
        $this->lastEpisode = $lastEpisode;
    }

    public function __toString()
    {
        return $this->name;
    }

    public static function fromJson($data)
    {
        return new self($data['name'], Episode::fromString($data['lastEpisode']));
    }

    public function jsonSerialize()
    {
        return [
            'name' => $this->name,
            'lastEpisode' => (string)$this->lastEpisode
        ];
    }
}
