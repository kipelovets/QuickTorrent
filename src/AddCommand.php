<?php
/**
 * kipelovets <kipelovets@mail.ru>
 */

namespace QuickTorrent;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddCommand extends Command
{
    /**
     * @var ShowRepository
     */
    private $repo;

    public function __construct(ShowRepository $repo)
    {
        $this->repo = $repo;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('add')
            ->setDescription('Adds new show')
            ->addArgument('name', InputArgument::REQUIRED, 'Full show name')
            ->addArgument('episode', InputArgument::REQUIRED, 'Last seen episode like "s05e03"')
            ;
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $episode = $input->getArgument('episode');
        $show = new Show($name, $episode);
        $this->repo->persist($show);
    }

} 