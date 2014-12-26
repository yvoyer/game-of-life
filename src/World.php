<?php
/**
 * This file is part of the game-life project.
 *
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\GameOfLife;

use Star\Component\Collection\TypedCollection;

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
     * @var Cell[]|TypedCollection
     */
    private $cells;

    /**
     * @var int
     */
    private $iteration = 0;

    /**
     * @param Cell[]        $cells
     */
    public function __construct(array $cells)
    {
        $this->cells = new TypedCollection(Cell::CLASS_NAME, $cells);
    }

    /**
     * @return int
     */
    public function size()
    {
        return $this->cells->count();
    }

    /**
     * @param CellId $id
     * @param CellRenderer $renderer
     *
     * @throws \RuntimeException
     * @return string
     */
    public function getContent(CellId $id, CellRenderer $renderer)
    {
        $predicate = function (Cell $cell) use ($id) {
            return $cell->id() == $id;
        };

        $cell = $this->cells->filter($predicate)->first();
        if (null === $cell) {
            throw new \RuntimeException("Cell with Id '{$id->x()},{$id->y()}' could not be found.");
        }

        return $renderer->render($cell);
    }

    public function run()
    {
        $this->iteration ++;
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
