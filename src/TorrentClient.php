<?php
/**
 * Коршунов Георгий <georgy.k@nevosoft.ru>
 */    

namespace QuickTorrent;

use \Transmission\Transmission;

class TorrentClient
{
    public function __construct()
    {
        $this->transmission = new Transmission('192.168.0.87', 9091, '/transmission/rpc');
    }

    public function addMagnetUrl($magnet) 
    {
        try {
            $this->transmission->add($magnet);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
