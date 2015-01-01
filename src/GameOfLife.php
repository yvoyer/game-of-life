<?php
/**
 * This file is part of the game-life project.
 *
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\GameOfLife;

use Star\GameOfLife\Renderer\ConsoleRenderer;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class GameOfLife
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\GameOfLife
 */
final class GameOfLife
{
    /**
     * @var World
     */
    private $world;

    /**
     * @var StateResolver
     */
    private $resolver;

    /**
     * @param int $rows
     * @param int $columns
     */
    public function __construct($rows = 15, $columns = 15)
    {
        $this->resolver = new StateResolver();
        $data = array();
        for ($i = 0; $i < $rows; $i ++) {
            for ($j = 0; $j < $columns; $j ++) {
                $data[$i][$j] = $this->resolver->deadCellOutput();
            }
        }
        $data[1][1] = $this->resolver->liveCellOutput();
        $data[2][2] = $this->resolver->liveCellOutput();
        $data[2][3] = $this->resolver->liveCellOutput();
        $data[3][1] = $this->resolver->liveCellOutput();
        $data[3][2] = $this->resolver->liveCellOutput();

        $this->world = World::fromArray($data, $this->resolver);
    }

    /**
     * @param OutputInterface $output
     * @param int             $maximumIteration
     */
    public function run(OutputInterface $output, $maximumIteration)
    {
        $this->world->run(new ConsoleRenderer($this->resolver, $output), $maximumIteration);
    }
}
