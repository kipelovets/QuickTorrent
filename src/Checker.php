<?php
/**
 * Коршунов Георгий <georgy.k@nevosoft.ru>
 */    

namespace QuickTorrent;

use QuickTorrent\TrackerClient\TrackerClient;

class Checker
{
    /** @var ShowRepository */
    public $repo;
    /** @var TrackerClient */
    public $tracker;
    /** @var TorrentClient */
    public $torrentClient;

    public function __construct(ShowRepository $repo, TrackerClient $tracker, TorrentClient $torrentClient)
    {
        $this->repo = $repo;
        $this->tracker = $tracker;
        $this->torrentClient = $torrentClient;
    }

    public function tryEpisode(Show $show, Episode $episode)
    {
        $magnet = $this->tracker->findMagnetUrl($show, $episode);
        if (!$magnet) {
            return false;
        }
        echo "\tFound new episode $episode\n";
        try {
            $this->torrentClient->addMagnetUrl($magnet);
        } catch (\Exception $e) {
            echo get_class($e) . ' ' . $e->getMessage(). PHP_EOL;
        }
        $show->lastEpisode = $episode;
        return true;
    }

    public function check()
    {
        $shows = $this->repo->findAll();
        foreach ($shows as $show) {
            echo "$show {$show->lastEpisode}\n";
            try {
                do {
                    $nextEpisode = $show->lastEpisode->nextEpisode();
                    $nextSeason = $show->lastEpisode->nextSeason();

                    $anythingFound = $this->tryEpisode($show, $nextEpisode) 
                                || $this->tryEpisode($show, $nextSeason);

                } while ($anythingFound);

            } catch (\Exception $e) {
                echo "Error checking {$show}: " . $e->getMessage() . PHP_EOL;   
            }
        }
    }
}
