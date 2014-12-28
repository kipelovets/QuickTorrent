<?php
/**
 * kipelovets <kipelovets@mail.ru>
 */

namespace QuickTorrent\HttpClientProvider;

use QuickTorrent\HttpClient\HttpClient;

interface HttpClientProvider
{
    /**
     * @return HttpClient
     */
    public function getHttpClient();

    public function runLoop();
}