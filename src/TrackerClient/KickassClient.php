<?php
/**
 * kipelovets <kipelovets@mail.ru>
 */

namespace QuickTorrent\TrackerClient;

use QuickTorrent\Episode;
use QuickTorrent\HttpClient\HttpClient;
use QuickTorrent\Show;
use Symfony\Component\DomCrawler\Crawler;

class KickassClient implements TrackerClient
{
    private function formatUrl(Show $show, Episode $episode)
    {
        $searchString = rawurlencode("{$show} {$episode}");
        return "https://kickass.so/usearch/{$searchString}/";
    }

    /** @var HttpClient */
    private $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function lookupTorrentMagnetUrl(Show $show, Episode $episode, $callback)
    {
        $this->extractMagnetUrls($show, $episode, function ($urls) use ($callback) {
            if (!$urls) {
                return null;
            }
            $callback($urls[0]);
        });
    }

    private function extractMagnetUrls(Show $show, Episode $episode, $callback)
    {
        $uri = $this->formatUrl($show, $episode);

        $this->httpClient->get($uri, function ($page) use ($show, $episode, $uri, $callback) {
            $page = gzdecode($page);
            $page = new Crawler($page, $uri);
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
        }, function ($error) {
            var_dump($error);
        });
    }
}