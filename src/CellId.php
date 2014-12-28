<?php
/**
 * This file is part of the game-life project.
 *
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\GameOfLife;

/**
 * Class CellId
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\GameOfLife
 */
final class CellId
{
    const CLASS_NAME = __CLASS__;

    /**
     * @var int
     */
    private $x;

    /**
     * @var int
     */
    private $y;

    /**
     * @param int $x
     * @param int $y
     * @throws \InvalidArgumentException
     */
    public function __construct($x, $y)
    {
        if (false === is_numeric($x) || false === ($x > 0)) {
            throw new \InvalidArgumentException('x position must be a positive integer.');
        }

        if (false === is_numeric($y) || false === ($y > 0)) {
            throw new \InvalidArgumentException('y position must be a positive integer.');
        }

        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @return int
     */
    public function x()
    {
        return $this->x;
    }

    /**
     * @return int
     */
    public function y()
    {
        return $this->y;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->x() . ',' . $this->y();
    }
}
