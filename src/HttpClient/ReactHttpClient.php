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
        $headers = [
            'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 YaBrowser/14.12.2125.9577 Safari/537.36'
        ];
        $request = $this->client->request('GET', $url, $headers);
        $request->on('error', $errorCallback);
        $request->on('response', function (Response $response) use ($url, $okCallback, $errorCallback) {
            if ($response->getCode() != 200) {
                echo $response->getCode() . " $url\n";
            }
            $response->on('error', $errorCallback);
            $response->on('data', function ($data) use ($okCallback) {
                $okCallback($data);
            });
        });
        $request->end();
    }
}