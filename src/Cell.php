<?php
/**
 * This file is part of the game-life project.
 *
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\GameOfLife;

/**
 * Class Cell
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\GameOfLife
 */
class Cell
{
    const CLASS_NAME = __CLASS__;
    const ALIVE = 1;
    const DEAD = 2;

    /**
     * @var CellId
     */
    private $id;

    /**
     * @var string
     */
    private $content;

    /**
     * @var int
     */
    private $status;

    /**
     * @param CellId $id
     * @param int    $status
     */
    public function __construct(CellId $id, $status)
    {
        $this->id = $id;
        $this->setStatus($status);
    }

    /**
     * @return CellId
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function content()
    {
        return $this->content;
    }

    /**
     * @param StateResolver $configuration
     *
     * @return bool
     */
    public function matchConfiguration(StateResolver $configuration)
    {
//        return
    }

    /**
     * @return bool
     */
    public function isDead()
    {
        return $this->status === self::DEAD;
    }

    /**
     * @return bool
     */
    public function isAlive()
    {
        return $this->status === self::ALIVE;
    }

    private function setStatus($status)
    {
        $supportedStatuses = array(
            self::DEAD,
            self::ALIVE,
        );

        if (false === array_search($status, $supportedStatuses)) {
            throw new \InvalidArgumentException("The cell status '{$status}' is not supported.");
        }
        $this->status = $status;
    }

    /**
     * @param CellId $id
     *
     * @return bool
     */
    public function isNeighbour(CellId $id)
    {
        // horizontal
        if ($this->id->x() == $id->x()) {
            if (($this->id->y() + 1 == $id->y()) || ($this->id->y() - 1 == $id->y())) {
                return true;
            }
        }

        // vertical
        if ($this->id->y() == $id->y()) {
            if (($this->id->x() + 1 == $id->x()) || ($this->id->x() - 1 == $id->x())) {
                return true;
            }
        }

        // top left corner
        if (($this->id->x() - 1 == $id->x()) && ($this->id->y() - 1 == $id->y())) {
            return true;
        }

        // right bottom corner
        if (($this->id->x() + 1 == $id->x()) && ($this->id->y() + 1 == $id->y())) {
            return true;
        }

        // bottom left corner
        if (($this->id->x() + 1 == $id->x()) && ($this->id->y() - 1 == $id->y())) {
            return true;
        }

        // right top corner
        if (($this->id->x() - 1 == $id->x()) && ($this->id->y() + 1 == $id->y())) {
            return true;
        }

        return false;
    }
}
