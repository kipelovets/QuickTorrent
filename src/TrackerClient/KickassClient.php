<?php
/**
 * kipelovets <kipelovets@mail.ru>
 */

namespace QuickTorrent\TrackerClient;

use Goutte\Client;
use QuickTorrent\Episode;
use QuickTorrent\Show;

class KickassClient implements TrackerClient
{
    public function lookupTorrentMagnetUrl(Show $show, Episode $episode)
    {
        $urls = $this->extractMagnetUrls($show, $episode);
        if (!$urls) {
            return null;
        }
        return $urls[0];
    }

    private function formatUrl(Show $show, Episode $episode)
    {
        $searchString = rawurlencode("{$show} {$episode}");
        return "https://kickass.so/usearch/{$searchString}/";
    }

    private function extractMagnetUrls(Show $show, Episode $episode)
    {
        $uri = $this->formatUrl($show, $episode);

        $client = new Client();
        $page = $client->request('GET', $uri);

        $result = $page->filter('.odd');
        $title = trim($result->filter('.torrentname')->text());
        if (!preg_match("/{$show}.*{$episode}/i", $title)) {
            return [];
        }

        $nodes = $result->filter("a[title='Torrent magnet link']");
        if ($nodes->count() == 0) {
            return [];
        }

        return [ $nodes->getNode(0)->getAttribute('href') ];
    }
}