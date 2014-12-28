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
     * @param CellCollection|Cell[] $collection
     *
     * @return CellCollection
     */
    public function resolveNextStage(CellCollection $collection)
    {
        $nextStage = $collection->duplicate();

        foreach ($collection as $cell) {
            $id = $cell->id();

            $aliveNeighbourCells = $collection->findAliveNeighboursCells($id);
            $aliveNeighborsCount = count($aliveNeighbourCells);

            $survives = false;
            if ($cell->isAlive() && $aliveNeighborsCount == 2) {
                $survives = true;
            }

            if ($aliveNeighborsCount == 3) {
                $survives = true;
            }

            $nextStageCell = $nextStage->findCellById($id);
            if ($survives) {
                $nextStageCell->resurrect();
            } else {
                $nextStageCell->kill();
            }
        }

        return $nextStage;
    }
}
