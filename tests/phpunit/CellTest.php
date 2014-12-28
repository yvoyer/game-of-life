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
        $this->cell = new Cell(new CellId(3, 3), Cell::ALIVE);
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

    /**
     * @dataProvider provideNeighborsCells
     */
    public function test_should_determine_neighbor($expected, $x, $y)
    {
        $this->assertSame($expected, $this->cell->isNeighbour(new CellId($x, $y)));
    }

    /**
     * | 1,1 | 1,2 | 1,3 | 1,4 | 1,5 |
     * | 2.1 | 2,2 | 2,3 | 2,4 | 2,5 |
     * | 3.1 | 3,2 |(3,3)| 3,4 | 3,5 |
     * | 4.1 | 4,2 | 4,3 | 4,4 | 4,5 |
     * | 5.1 | 5,2 | 5,3 | 5,4 | 5,5 |
     */
    public function provideNeighborsCells()
    {
        return array(
            array(false, 1, 1),
            array(false, 1, 2),
            array(false, 1, 3),
            array(false, 1, 4),
            array(false, 1, 5),
            array(false, 2, 1),
            array(true, 2, 2),
            array(true, 2, 3),
            array(true, 2, 4),
            array(false, 2, 5),
            array(false, 3, 1),
            array(true, 3, 2),
            'self is not considered neighbor' => array(false, 3, 3),
            array(true, 3, 4),
            array(false, 3, 5),
            array(false, 4, 1),
            array(true, 4, 2),
            array(true, 4, 3),
            array(true, 4, 4),
            array(false, 4, 5),
            array(false, 5, 1),
            array(false, 5, 2),
            array(false, 5, 3),
            array(false, 5, 4),
            array(false, 5, 5),
        );
    }

    public function test_should_kill_cell()
    {
        $cell = new Cell(new CellId(1, 2), Cell::ALIVE);
        $this->assertTrue($cell->isAlive());
        $cell->kill();
        $this->assertTrue($cell->isDead());
    }

    public function test_should_reanimate_cell()
    {
        $cell = new Cell(new CellId(1, 2), Cell::DEAD);
        $this->assertTrue($cell->isDead());
        $cell->resurrect();
        $this->assertTrue($cell->isAlive());
    }
}
