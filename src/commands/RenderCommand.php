<?php

namespace Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use App\Cache;

class RenderCommand extends Command
{
    protected function configure() {
        $this->setName('render')
            ->setDescription('Pixelates the chosen image');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        dump('Pixelating the image...');

        # using process run convert input.jpg -resize 64x64! -filter point -resize 512x512 output.png
        $targetFile = Cache::get('targetFile');
        $outputFilePath = Cache::get('outputFilePath');
        $aspectRatio = Cache::get('aspectRatio');
        $chosenOutputSize = Cache::get('chosenOutputSize');

        $command = sprintf(
            'convert %s -resize %dx%d! -filter point -resize %s %s',
            $targetFile,
            $aspectRatio['width'] * 20,
            $aspectRatio['height'] * 20,
            $chosenOutputSize,
            $outputFilePath
        );
        
        $process = Process::fromShellCommandline($command);
        $process->run();
        
        // Executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        
        $output->writeln('Image has been pixelated successfully!');
        return Command::SUCCESS;
    }
}