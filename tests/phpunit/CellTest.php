<?php
/**
 * This file is part of the game-life project.
 *
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\GameOfLife;

/**
 * Class CellTest
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\GameOfLife
 */
final class CellTest extends \PHPUnit_Framework_TestCase
{
    const CLASS_NAME = __CLASS__;

    /**
     * @var Cell
     */
    private $cell;

    public function setUp()
    {
        $this->cell = new Cell(new CellId(1, 2), Cell::ALIVE);
    }

    public function test_should_be_alive()
    {
        $this->assertTrue($this->cell->isAlive());
        $this->assertFalse($this->cell->isDead());
    }

    public function test_should_be_dead()
    {
        $this->cell = new Cell(new CellId(1, 2), Cell::DEAD);
        $this->assertFalse($this->cell->isAlive());
        $this->assertTrue($this->cell->isDead());
    }

    /**
     * @expectedException        \InvalidArgumentException
     * @expectedExceptionMessage The cell status '321321' is not supported.
     */
    public function test_should_throw_exception_when_bad_status_given()
    {
        new Cell(new CellId(1, 2), 321321);
    }
}
