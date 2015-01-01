<?php
/**
 * This file is part of the game-life project.
 *
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\GameOfLife\Renderer;

use Star\GameOfLife\Cell;
use Star\GameOfLife\CellCollection;
use Star\GameOfLife\StateResolver;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ConsoleRenderer
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\GameOfLife\Renderer
 */
final class ConsoleRenderer implements CellRenderer
{
    const CLASS_NAME = __CLASS__;

    /**
     * @var StateResolver
     */
    private $resolver;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @param StateResolver   $resolver
     * @param OutputInterface $output
     */
    public function __construct(StateResolver $resolver, OutputInterface $output)
    {
        $this->resolver = $resolver;
        $this->output = $output;
    }

    /**
     * @param Cell $cell
     *
     * @return string
     */
    private function renderCell(Cell $cell)
    {
        return $this->resolver->resolveContent($cell);
    }

    /**
     * @param CellCollection $line
     *
     * @return string
     */
    private function renderLine(CellCollection $line)
    {
        $string = '';
        foreach ($line as $column) {
            $string .= $this->renderCell($column);
        }

        $this->output->writeln($string);

        return $string;
    }

    /**
     * @param CellCollection $cells
     */
    public function renderGrid(CellCollection $cells)
    {
        $cellCount = $cells->size();
        for ($i = 1; $i <= $cellCount; $i ++) {
            $rows = $cells->findCellsOfRow($i);

            if (empty($rows)) {
                break; // Reach the end of the cells row
            }

            $this->renderLine(new CellCollection($rows));
        }
    }
}
