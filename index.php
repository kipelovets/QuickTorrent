<?php
/**
 * kipelovets <kipelovets@mail.ru>
 */

namespace QuickTorrent;

use Symfony\Component\Console\Application;

require_once('vendor/autoload.php');

$torrentClient = new TorrentClient;
$tracker = new Tracker;
$repo = new ShowRepository;

$app = new Application();
$app->add(new UpdateCommand($repo, $tracker, $torrentClient));
$app->add(new AddCommand($repo));
$app->setDefaultCommand('update');
$app->run();