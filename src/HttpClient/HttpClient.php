<?php
/**
 * kipelovets <kipelovets@mail.ru>
 */

namespace QuickTorrent\HttpClient;

interface HttpClient
{
    public function get($url, callable $okCallback, callable $errorCallback);
} 