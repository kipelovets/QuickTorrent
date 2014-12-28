<?php
/**
 * kipelovets <kipelovets@mail.ru>
 */

namespace QuickTorrent\HttpClient;

use React\HttpClient\Client;
use React\HttpClient\Response;

class ReactHttpClient implements HttpClient
{
    /** @var Client */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function get($url, callable $okCallback, callable $errorCallback)
    {
        $request = $this->client->request('GET', $url);
        $request->on('response', function (Response $response) use ($okCallback) {
            $response->on('data', function ($data) use ($okCallback) {
                $okCallback($data);
            });
        });
        $request->end();
    }
}