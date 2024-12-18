<?php

namespace Commands;

require dirname(__DIR__).'/vendor/autoload.php';

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use App\Cache; 
use App\Dimensions;

class ChooseAspectRatioCommand extends Command
{
    protected function configure() {
        $this->setName('choose:aspect-ratio')
            ->setDescription('Choose a target aspect ratio for the image');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        # ask for width
        $helper = $this->getHelper('question');
        $question = new Question('Please enter the required aspect ratio: ');
        $aspectRatio = $helper->ask($input, $output, $question);

        # use regex to validate the input
        if (!preg_match('/^\d+:\d+$/', $aspectRatio)) {
            $output->writeln('<error>Invalid aspect ratio. Please use the format "width:height".</error>');
            return Command::FAILURE;
        }

        # store the aspect ratio in the cache
        Cache::set('aspectRatio', new Dimensions($aspectRatio));

        $output->writeln('Aspect ratio has been set to ' . $aspectRatio);

        return Command::SUCCESS;
    }
}
