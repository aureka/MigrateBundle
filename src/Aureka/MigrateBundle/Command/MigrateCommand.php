<?php

namespace Aureka\MigrateBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrateCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('aureka_migrate:migrate')
            ->setDescription('Migrates a database.');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Migrating database...');
        $this->getContainer()
            ->get('aureka_migrate.migration')
            ->execute();
        $output->writeln('Done!');
    }
}
