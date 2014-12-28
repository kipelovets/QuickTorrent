<?php
/**
 * kipelovets <kipelovets@mail.ru>
 */

namespace QuickTorrent\HttpClientProvider;

use QuickTorrent\HttpClient\HttpClient;
use QuickTorrent\HttpClient\ReactHttpClient;
use React\EventLoop\LoopInterface;
use React\HttpClient\Client;

class ReactHttpClientProvider implements HttpClientProvider
{
    /** @var LoopInterface */
    private $loop;
    /** @var Client */
    private $client;
    /** @var ReactHttpClient */
    private $clientAdapter;

    public function __construct(LoopInterface $loop, Client $client)
    {
        $this->loop = $loop;
        $this->client = $client;
        $this->clientAdapter = new ReactHttpClient($client);
    }

    /**
     * @return HttpClient
     */
    public function getHttpClient()
    {
        return $this->clientAdapter;
    }

    public function runLoop()
    {
        $this->loop->run();
    }
}