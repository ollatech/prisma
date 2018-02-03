<?php

namespace Olla\Prisma\Command;

use Olla\Prisma\Metadata\MetadataInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\Output;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MetadataCommand extends Command
{
    private $discover;

    public function __construct(MetadataInterface $discover)
    {
        parent::__construct();
        $this->discover = $discover;
    }

    protected function configure()
    {
        $this
        ->setName('prisma:metadata:discover')
        ->setDescription('Generate types manually.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Types compilation starts</info>');
        $resources = $this->discover->resources();
        print_r($resources);
    }
}
