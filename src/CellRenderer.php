<?php
/**
 * This file is part of the game-life project.
 *
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\GameOfLife;

/**
 * Class CellRenderer
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\GameOfLife
 */
interface CellRenderer
{
    const INTERFACE_NAME = __CLASS__;

    /**
     * @param Cell $cell
     *
     * @return string
     */
    public function render(Cell $cell);

    /**
     * @return string
     */
    public function renderLineFeed();

    /**
     * @param CellCollection $line
     *
     * @return string
     */
    public function renderLine(CellCollection $line);
}
