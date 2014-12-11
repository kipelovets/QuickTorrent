<?php
/**
 * kipelovets <kipelovets@mail.ru>
 */
namespace QuickTorrent\TrackerClient;

use QuickTorrent\Episode;
use QuickTorrent\Show;

interface TrackerClient
{
    public function findMagnetUrl(Show $show, Episode $episode);
}