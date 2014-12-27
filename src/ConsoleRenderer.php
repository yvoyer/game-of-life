<?php
/**
 * This file is part of the game-life project.
 *
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\GameOfLife;

/**
 * Class ConsoleRenderer
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\GameOfLife
 */
final class ConsoleRenderer implements CellRenderer
{
    const CLASS_NAME = __CLASS__;

    /**
     * @var StateResolver
     */
    private $resolver;

    /**
     * @param StateResolver $resolver
     */
    public function __construct(StateResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * @param Cell $cell
     *
     * @return string
     */
    public function render(Cell $cell)
    {
        return $this->resolver->resolveContent($cell);
    }

    /**
     * @return string
     */
    public function renderLineFeed()
    {
        return "\n";
    }
}
