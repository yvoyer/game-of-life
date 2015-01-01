<?php
/**
 * This file is part of the game-life project.
 *
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\GameOfLife\Renderer;

use Star\GameOfLife\CellCollection;

/**
 * Class CellRenderer
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\GameOfLife\Renderer
 */
interface CellRenderer
{
    const INTERFACE_NAME = __CLASS__;

    /**
     * @param CellCollection $cells
     */
    public function renderGrid(CellCollection $cells);
}
