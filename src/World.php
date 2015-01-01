<?php
/**
 * This file is part of the game-life project.
 *
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\GameOfLife;

use Star\GameOfLife\Renderer\CellRenderer;

/**
 * Class World
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\GameOfLife
 */
final class World
{
    const CLASS_NAME = __CLASS__;

    /**
     * @var Cell[]|CellCollection
     */
    private $cells;

    /**
     * @var int
     */
    private $iteration = 0;

    /**
     * @var LifeResolver
     */
    private $lifeResolver;

    /**
     * @param Cell[]       $cells
     * @param LifeResolver $resolver todo remove when life resolver works
     */
    public function __construct(array $cells, LifeResolver $resolver = null)
    {
        if (null === $resolver) {
            $resolver = new LifeResolver();
        }

        $this->lifeResolver = $resolver;
        $this->cells = new CellCollection($cells);
    }

    /**
     * @return int
     */
    public function size()
    {
        return $this->cells->size();
    }

    /**
     * @param CellRenderer $renderer
     * @param int          $maximumIteration
     */
    public function run(CellRenderer $renderer, $maximumIteration)
    {
        for ($i = 0; $i < $maximumIteration; $i++) {
            $this->iteration ++;
            $this->cells = $this->lifeResolver->resolveNextStage($this->cells);
            $renderer->renderGrid($this->cells);
        }
    }

    /**
     * @return int
     */
    public function iteration()
    {
        return $this->iteration;
    }

    /**
     * @param array         $worldData
     * @param StateResolver $resolver
     *
     * @return World
     */
    public static function fromArray(array $worldData, StateResolver $resolver)
    {
        $cells = array();
        foreach ($worldData as $x => $columns) {
            foreach ($columns as $y => $cellData) {
                $cells[] = new Cell(new CellId($x + 1, $y + 1), $resolver->resolveStatus($cellData));
            }
        }

        return new World($cells);
    }
}
