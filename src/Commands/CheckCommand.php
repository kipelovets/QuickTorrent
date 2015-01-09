<?php
/**
 * kipelovets <kipelovets@mail.ru>
 */

namespace QuickTorrent\Commands;

use QuickTorrent\Checker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
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
        $this->setName('check')
            ->setDescription('Check shows for new episodes')
            ->addOption('all', '-a', InputOption::VALUE_NONE, 'Continue searching for episodes if any was found')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $recurse = $input->getOption('all');
        $this->checker->check($recurse);
    }
}