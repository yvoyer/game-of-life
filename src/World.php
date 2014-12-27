<?php
/**
 * This file is part of the game-life project.
 *
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\GameOfLife;

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
     * @param CellId $id
     * @param CellRenderer $renderer
     *
     * @throws \RuntimeException
     * @return string
     */
    public function getContent(CellId $id, CellRenderer $renderer)
    {
        $cell = $this->cells->findCellById($id);
        if (null === $cell) {
            throw new \RuntimeException("Cell with Id '{$id->x()},{$id->y()}' could not be found.");
        }

        return $renderer->render($cell);
    }

    /**
     * @param CellRenderer $renderer
     *
     * @return string
     */
    public function run(CellRenderer $renderer)
    {
        $this->iteration ++;
        $this->cells = $this->lifeResolver->resolveNextStage($this->cells);

        return $this->render($renderer);
    }

    private function render(CellRenderer $renderer)
    {
        $cellCount = $this->size();
        $string = '';
        for ($i = 1; $i <= $cellCount; $i ++) {
            $rows = $this->cells->findCellsOfRow($i);
            if (empty($rows)) {
                break; // Reach the end of the cells row
            } else {
                foreach ($rows as $column) {
                    $string .= $renderer->render($column);
                }
                $string .= $renderer->renderLineFeed();
            }
        }

        return $string;
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
