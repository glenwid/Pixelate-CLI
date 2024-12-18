#!/usr/bin/env php
<?php

require __DIR__.'/vendor/autoload.php';

use Commands\ChooseFileCommand;
use Symfony\Component\Console\Application;
use Commands\GetCacheCommand;
use Commands\ChooseAspectRatioCommand;
use Commands\ChooseOutputSizeCommand;
use Commands\DumpCacheCommand;
use Commands\RenderCommand;
use Commands\ChooseStepSizeCommand; 

$application = new Application();

$application->addCommands([
    new ChooseFileCommand(),
    new GetCacheCommand(),
    new ChooseAspectRatioCommand(),
    new ChooseOutputSizeCommand(),
    new DumpCacheCommand(), 
    new RenderCommand(),
    new ChooseStepSizeCommand()
]);

$application->run();