<?php
/**
 * kipelovets <kipelovets@mail.ru>
 */

namespace QuickTorrent\Commands;

use QuickTorrent\Checker;
use QuickTorrent\ShowRepository;
use QuickTorrent\TorrentClient;
use QuickTorrent\TrackerClient\TrackerClient;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CheckCommand extends Command
{
    /** @var Checker */
    private $checker;

    public function __construct(Checker $checker)
    {
        $this->checker = $checker;
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
        $this->checker->check();
    }
}