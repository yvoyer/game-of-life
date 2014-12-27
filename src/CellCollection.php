<?php
/**
 * This file is part of the game-life project.
 *
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\GameOfLife;

use Star\Component\Collection\TypedCollection;

/**
 * Class CellCollection
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\GameOfLife
 */
final class CellCollection
{
    /**
     * @var Cell[]|TypedCollection
     */
    private $cells;

    /**
     * @param Cell[] $cells
     */
    public function __construct(array $cells)
    {
        $this->cells = new TypedCollection(Cell::CLASS_NAME, $cells);
    }

    /**
     * @param CellId $id
     *
     * @return Cell|null
     */
    public function findCellById(CellId $id)
    {
        $predicate = function (Cell $cell) use ($id) {
            return $cell->id() == $id;
        };

        return $this->cells->filter($predicate)->first();
    }

    /**
     * @param int $x
     *
     * @return Cell[]
     */
    public function findCellsOfRow($x)
    {
        $rowSearcher = function(Cell $cell) use ($x) {
            return $cell->id()->x() == $x;
        };

        return $this->cells->filter($rowSearcher)->toArray();
    }

    /**
     * @return int
     */
    public function size()
    {
        return $this->cells->count();
    }

    /**
     * @return Cell[]
     */
    public function findAliveCells()
    {
        $predicate = function(Cell $cell) {
            return $cell->isAlive();
        };

        return $this->cells->filter($predicate)->toArray();
    }

    /**
     * @param CellId $id
     *
     * @return Cell[]
     */
    public function findNeighborsCells(CellId $id)
    {
        $predicate = function(Cell $cell) use ($id) {
            return $cell->isNeighbour($id);
        };

        return $this->cells->filter($predicate)->toArray();
    }
}
