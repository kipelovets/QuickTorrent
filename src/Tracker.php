<?php
/**
 * Коршунов Георгий <georgy.k@nevosoft.ru>
 */    

namespace QuickTorrent;

class Tracker
{
    public function findMagnetUrl(Show $show, Episode $episode) 
    {
        $urls = $this->extractMagnetUrls($this->formatUrl($show, $episode));
        if (!$urls) {
            return null;
        }
        return $urls[0];
    }

    private function formatUrl(Show $show, Episode $episode)
    {
        return "http://thepiratebay.se/search/{$show} {$episode}/0/7/0";
    }

    private function extractMagnetUrls($uri)
    {
        $page = file_get_contents($uri);
        $crawler = new \Symfony\Component\DomCrawler\Crawler($page, $uri);
        $nodes = $crawler->filter(".detName");
        if ($nodes->count() == 0) {
            return [];
        }

        return [ $nodes->first()->siblings()->first()->getNode(0)->getAttribute('href') ];
    }
}
