<?php

namespace Commands;

require dirname(__DIR__).'/vendor/autoload.php';

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Finder\Finder;
use App\Cache; 

class ChooseFileCommand extends Command
{
    protected function configure() {
        $this->setName('choose:file')
            ->setDescription('Scans a directory and lets the user choose a file');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        # Define the directory to scan
        $directory = dirname(realpath(__DIR__), 2) . '/input'; // Adjust your path here

        # Use Finder to locate files
        $finder = new Finder();
        $finder->files()->in($directory);

        # Check if files exist
        if (!$finder->hasResults()) {
            $output->writeln('<error>No files found in the specified directory.</error>');
            return Command::FAILURE;
        }

        # Create a list of filenames for the choice question
        $fileChoices = [];
        foreach ($finder as $file) {
            $fileChoices[] = $file->getFilename();
        }

        # Ask the user to choose a file
        $helper = $this->getHelper('question');
        $question = new ChoiceQuestion(
            'Please choose an image to pixelate:',
            $fileChoices
        );
        $question->setErrorMessage('File %s is invalid.');

        $chosenFile = $helper->ask($input, $output, $question);

        # Display the chosen file
        $output->writeln(sprintf('You selected: <info>%s</info>', $chosenFile));

        # Store the chosen file in the cache
        Cache::set('targetFile', $directory . '/' . $chosenFile);

        return Command::SUCCESS;
    }
}
