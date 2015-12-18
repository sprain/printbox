<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HeartbeatCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('printbox:heartbeat')
            ->setDescription('Sends a heartbeat to the server');
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try{
            $ip = $this->getContainer()->get('printbox.heartbeat')->sendHeartbeat();
            $output->writeln('<info>Heartbeat sent ('.$ip.').</info>');
        } catch(\Exception $e) {
            $output->writeln('<error>'.$e->getMessage().'</error>');
        }
    }
}