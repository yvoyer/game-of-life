#!/usr/bin/env php
<?php
/**
 * This file is part of the game-life project.
 *
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

require_once 'vendor/autoload.php';

$application = new \Symfony\Component\Console\Application('Game of life', '1.0.0');
$application->setCatchExceptions(false);

$output = new \Symfony\Component\Console\Output\ConsoleOutput();

$application->add(new \Star\GameOfLife\RunCommand());
$application->run(new \Symfony\Component\Console\Input\ArgvInput($argv), $output);
