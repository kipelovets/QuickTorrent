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
        $arg = urlencode("{$show} {$episode}");
        return "http://thepiratebay.cr/search/$arg/0/7/0";
    }
}
