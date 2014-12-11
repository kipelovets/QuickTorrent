<?php
/**
 * kipelovets <kipelovets@mail.ru>
 */

namespace QuickTorrent;

use QuickTorrent\TrackerClient\TrackerClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateCommand extends Command
{
    /** @var ShowRepository */
    private $repo;
    /** @var TrackerClient */
    private $tracker;
    /** @var TorrentClient */
    private $torrentClient;

    public function __construct(ShowRepository $repo, TrackerClient $tracker, TorrentClient $torrentClient)
    {
        $this->repo = $repo;
        $this->tracker = $tracker;
        $this->torrentClient = $torrentClient;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('update')
            ->setDescription('Updates shows')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $checker = new Checker($this->repo, $this->tracker, $this->torrentClient);
        $checker->check();
    }
}