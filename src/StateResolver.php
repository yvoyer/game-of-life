<?php
/**
 * This file is part of the game-life project.
 *
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\GameOfLife;

/**
 * Class StateResolver
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\GameOfLife
 */
final class StateResolver
{
    /**
     * @var string
     */
    private $liveCellOutput = '*';

    /**
     * @var string
     */
    private $deadCellOutput = ' ';

    /**
     * Set the deadCell.
     *
     * @param string $deadCell
     */
    public function setDeadCellOutput($deadCell)
    {
        $this->deadCellOutput = $deadCell;
        $this->guardAgainstSameOutput();
    }

    /**
     * Returns the DeadCell.
     *
     * @return string
     */
    public function deadCellOutput()
    {
        return $this->deadCellOutput;
    }

    /**
     * Set the liveCell.
     *
     * @param string $liveCell
     */
    public function setLiveCellOutput($liveCell)
    {
        $this->liveCellOutput = $liveCell;
        $this->guardAgainstSameOutput();
    }

    private function guardAgainstSameOutput()
    {
        if ($this->deadCellOutput == $this->liveCellOutput) {
            throw new \LogicException("The dead and live string can't be the same.");
        }
    }

    /**
     * Returns the LiveCell.
     *
     * @return string
     */
    public function liveCellOutput()
    {
        return $this->liveCellOutput;
    }

    /**
     * @param string $content
     *
     * @return int|null
     * @throws \LogicException
     */
    public function resolveStatus($content)
    {
        $status = null;
        switch ($content) {
            case $this->deadCellOutput:
                $status = Cell::DEAD;
                break;
            case $this->liveCellOutput:
                $status = Cell::ALIVE;
                break;
            default:
                throw new \LogicException("Content '{$content}' did not match any status.");
        }

        return $status;
    }

    /**
     * @param Cell $cell
     *
     * @throws \LogicException
     * @return string
     */
    public function resolveContent(Cell $cell)
    {
        if ($cell->isAlive()) {
            return $this->liveCellOutput();
        }

        if ($cell->isDead()) {
            return $this->deadCellOutput();
        }

        throw new \LogicException('No content mapping was found for cell state.');
    }
}
