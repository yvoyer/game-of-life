<?php
/**
 * This file is part of the game-life project.
 *
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\GameOfLife;

/**
 * Class LifeResolver
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\GameOfLife
 */
class LifeResolver
{
    const CLASS_NAME = __CLASS__;

    /**
     * Returns the next stage of evolution.
     *
     * @param CellCollection $collection
     *
     * @return CellCollection
     */
    public function resolveNextStage(CellCollection $collection)
    {
        $aliveCells = $collection->findAliveCells();

        return $collection;
    }
}
