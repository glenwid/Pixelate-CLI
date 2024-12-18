<?php 

namespace Commands;

use App\Cache;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DumpCacheCommand extends Command {
    protected function configure() {
        $this->setName('cache:dump')
            ->setDescription('Dumps all cache data');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        Cache::dump(); 
        return Command::SUCCESS;
    }
}