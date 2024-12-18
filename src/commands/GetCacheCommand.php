<?php

namespace Commands;

require dirname(__DIR__).'/vendor/autoload.php';

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

use App\Cache; 

class GetCacheCommand extends Command
{
    protected function configure() {
        $this->setName('cache:get')
            ->setDescription('Dumps cache data by key')
            ->addArgument('key', InputArgument::REQUIRED, 'The key to dump');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $key = $input->getArgument('key');
        $cacheData = Cache::get($key);
        dump($cacheData);
        return Command::SUCCESS;
    }
}
