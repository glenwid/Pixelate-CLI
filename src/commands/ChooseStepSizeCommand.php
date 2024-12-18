<?php 

namespace Commands; 

use App\Cache;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class ChooseStepSizeCommand extends Command {
    protected function configure() {
        $this->setName('choose:step-size')
            ->setDescription('Choose a step size for the output sizes generation');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $helper = $this->getHelper('question');
        $question = new Question('Please enter the required step size: ');
        $stepSize = $helper->ask($input, $output, $question);

        if (!is_numeric($stepSize) || $stepSize < 1) {
            $output->writeln('<error>Invalid step size. Please enter a number >= 1.</error>');
            return Command::FAILURE;
        }

        Cache::set('stepSize', $stepSize);

        $output->writeln('Step size has been set to ' . $stepSize);
        $aspectRatio = Cache::get('aspectRatio');
        $width = $aspectRatio['width'];
        $height = $aspectRatio['height'];

        # create multiples of the aspect ratio to use as output sizes 
        for($i = 1; $i <= 10; $i++) {
            $outputSizes[] = [
                'width' => $width * $stepSize * $i,
                'height' => $height * $stepSize * $i
            ];
        }
        
        # keep data in sync
        if(isset($outputSizes)) {
            Cache::set('outputSizes', $outputSizes);
        }

        $output->writeln('Output sizes have been updated');

        return Command::SUCCESS;
    }
    
}