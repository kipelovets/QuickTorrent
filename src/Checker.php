<?php
/**
 * Коршунов Георгий <georgy.k@nevosoft.ru>
 */    

namespace QuickTorrent;

use QuickTorrent\HttpClientProvider\HttpClientProvider;
use QuickTorrent\TrackerClient\TrackerClient;

class Checker
{
    /** @var ShowRepository */
    private $repo;
    /** @var TrackerClient */
    private $tracker;
    /** @var TorrentClient */
    private $torrentClient;
    /** @var HttpClientProvider */
    private $httpClientProvider;

    public function __construct(ShowRepository $repo, TrackerClient $tracker, TorrentClient $torrentClient,
        HttpClientProvider $httpClientProvider)
    {
        $this->repo = $repo;
        $this->tracker = $tracker;
        $this->torrentClient = $torrentClient;
        $this->httpClientProvider = $httpClientProvider;
    }

    private function tryEpisode(Show $show, Episode $episode, $recurse = false)
    {
        $this->tracker->lookupTorrentMagnetUrl($show, $episode, function ($magnet) use ($show, $episode, $recurse) {
            if (!$magnet) {
                return;
            }
            echo "\tFound new episode $show > $episode\n";
            try {
                $this->torrentClient->addMagnetUrl($magnet);
            } catch (\Exception $e) {
                echo get_class($e) . ' ' . $e->getMessage(). PHP_EOL;
            }
            $show->lastEpisode = $episode;
            if ($recurse) {
                $this->tryEpisode($show, $episode->nextEpisode());
            }
        });
    }

    public function check($recurse = false)
    {
        echo "Looking for new episodes...\n";
        $shows = $this->repo->findAll();
        foreach ($shows as $show) {
            try {
                $nextEpisode = $show->lastEpisode->nextEpisode();
                $this->tryEpisode($show, $nextEpisode, $recurse);

                $nextSeason = $show->lastEpisode->firstEpisodeNextSeason();
                $this->tryEpisode($show, $nextSeason, $recurse);

            } catch (\Exception $e) {
                echo "Error checking {$show}: " . $e->getMessage() . PHP_EOL;   
            }
        }
        $this->httpClientProvider->runLoop();
        echo "Done.\n";
    }
}
