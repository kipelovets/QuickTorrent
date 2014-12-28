<?php
/**
 * Коршунов Георгий <georgy.k@nevosoft.ru>
 */    

namespace QuickTorrent\TrackerClient;

use QuickTorrent\Episode;
use QuickTorrent\HttpClient\HttpClient;
use QuickTorrent\Show;
use Symfony\Component\DomCrawler\Crawler;

class ThePirateBayClient implements TrackerClient
{
    /** @var HttpClient */
    private $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function lookupTorrentMagnetUrl(Show $show, Episode $episode, $callback)
    {
        $this->extractMagnetUrls($this->formatUrl($show, $episode), function ($urls) use ($callback) {
            if (!$urls) {
                return null;
            }
            $callback($urls[0]);
        });
    }

    protected function formatUrl(Show $show, Episode $episode)
    {
        return "http://thepiratebay.se/search/{$show} {$episode}/0/7/0";
    }

    private function extractMagnetUrls($uri, $callback)
    {
        $this->httpClient->get($uri, function ($page) use ($uri, $callback) {
            $crawler = new Crawler($page, $uri);
            $nodes = $crawler->filter(".detName");
            if ($nodes->count() == 0) {
                return;
            }

            $callback([ $nodes->first()->siblings()->first()->getNode(0)->getAttribute('href') ]);
        }, function () {});
    }
}
