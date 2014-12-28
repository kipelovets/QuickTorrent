<?php
/**
 * kipelovets <kipelovets@mail.ru>
 */
namespace QuickTorrent\TrackerClient;

use QuickTorrent\Episode;
use QuickTorrent\Show;

interface TrackerClient
{
    public function lookupTorrentMagnetUrl(Show $show, Episode $episode, $callback);
}