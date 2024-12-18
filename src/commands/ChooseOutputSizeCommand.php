<?php 

namespace Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

use App\Cache; 

class ChooseOutputSizeCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('choose:output-size')
            ->setDescription('Choose the output size of the image')
            ->setHelp('This command allows you to choose the output size of the image based on the selected dimensions');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $outputSizes = Cache::get('outputSizes');
        
        if(!$outputSizes) {
            $output->writeln('<error>No output sizes generated. Please run choose:aspect-ratio command first.</error>');
            return Command::FAILURE;
        }

        # generate string representation of the output sizes
        $outputSizes = array_map(function($size) {
            return $size['width'] . 'x' . $size['height'];
        }, $outputSizes);

        # ask the user to choose the output size
        $helper = $this->getHelper('question');

		$stageQuestion = new ChoiceQuestion(
			'Please select the output size of the image',
			$outputSizes,
			0
		);
        
        $chosenOutputSize = $helper->ask($input, $output, $stageQuestion);

        Cache::set('chosenOutputSize', $chosenOutputSize);

        $output->writeln('Output size has been set to ' . $chosenOutputSize);

        return Command::SUCCESS;
    }
}