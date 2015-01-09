#!/usr/bin/env php
<?php
/**
 * kipelovets <kipelovets@mail.ru>
 */

namespace QuickTorrent;

use QuickTorrent\Commands\AddCommand;
use QuickTorrent\Commands\CheckCommand;
use QuickTorrent\HttpClientProvider\ReactHttpClientProvider;
use QuickTorrent\TrackerClient\KickassClient;
use Symfony\Component\Console\Application;

require_once('vendor/autoload.php');

date_default_timezone_set("Europe/Moscow");

$torrentClient = new TorrentClient;

$repo = new ShowRepository;

$loop = \React\EventLoop\Factory::create();

$dnsResolverFactory = new \React\Dns\Resolver\Factory();
$dnsResolver = $dnsResolverFactory->createCached('8.8.8.8', $loop);

$factory = new \React\HttpClient\Factory();
$client = $factory->create($loop, $dnsResolver);

$httpClientProvider = new ReactHttpClientProvider($loop, $client);

$tracker = new KickassClient($httpClientProvider->getHttpClient());

$checker = new Checker($repo, $tracker, $torrentClient, $httpClientProvider);

$app = new Application();
$app->add(new CheckCommand($checker));
$app->add(new AddCommand($repo));
$app->setDefaultCommand('check');
$app->run();
