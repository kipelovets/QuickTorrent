<?php
/**
 * Коршунов Георгий <georgy.k@nevosoft.ru>
 */    

namespace QuickTorrent\TrackerClient;

use QuickTorrent\Episode;
use QuickTorrent\Show;
use Symfony\Component\DomCrawler\Crawler;

class ThePirateBayCrClient extends ThePirateBayClient implements TrackerClient
{
    protected function formatUrl(Show $show, Episode $episode)
    {
        return "http://thepiratebay.cz/search/{$show} {$episode}/0/7/0";
    }
}
