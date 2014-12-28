<?php
/**
 * This file is part of the game-life project.
 *
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\GameOfLife;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class RunCommand
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\GameOfLife
 */
final class RunCommand extends Command
{
    const CLASS_NAME = __CLASS__;

    protected function configure()
    {
        $this->setName('run');
        $this->addOption('maximum-iteration', 'i', InputOption::VALUE_REQUIRED, 'The maximum iteration count.', 1);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $max = $input->getOption('maximum-iteration');

        $gameOfLife = new GameOfLife();

        for ($i = 0; $i < $max; $i++) {
            $gameOfLife->run($output);
        }
    }
}
