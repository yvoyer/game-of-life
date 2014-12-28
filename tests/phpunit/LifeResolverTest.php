<?php
/**
 * This file is part of the game-life project.
 *
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\GameOfLife;

/**
 * Class LifeResolverTest
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\GameOfLife
 */
final class LifeResolverTest extends \PHPUnit_Framework_TestCase
{
    const CLASS_NAME = __CLASS__;

    /**
     * @var LifeResolver
     */
    private $resolver;

    public function setUp()
    {
        $this->resolver = new LifeResolver();
    }

    public function test_live_cells_with_two_and_less_live_neighbors_should_die_of_underpopulation()
    {
        /**
         * ---
         * -*-
         * --*
         */
        $collection = new CellCollection(
            array(
                new Cell(new CellId(1, 1), Cell::DEAD),
                new Cell(new CellId(1, 2), Cell::DEAD),
                new Cell(new CellId(1, 3), Cell::DEAD),
                new Cell(new CellId(2, 1), Cell::DEAD),
                new Cell(new CellId(2, 2), Cell::ALIVE),
                new Cell(new CellId(2, 3), Cell::DEAD),
                new Cell(new CellId(3, 1), Cell::DEAD),
                new Cell(new CellId(3, 2), Cell::DEAD),
                new Cell(new CellId(3, 3), Cell::ALIVE),
            )
        );

        $actual = $this->resolver->resolveNextStage($collection);
        $this->assertTrue($actual->findCellById(new CellId(2, 2))->isDead());
    }

    public function test_live_cells_with_two_live_neighbors_should_survive()
    {
        /**
         * ---
         * -**
         * --*
         */
        $collection = new CellCollection(
            array(
                new Cell(new CellId(1, 1), Cell::DEAD),
                new Cell(new CellId(1, 2), Cell::DEAD),
                new Cell(new CellId(1, 3), Cell::DEAD),
                new Cell(new CellId(2, 1), Cell::DEAD),
                new Cell(new CellId(2, 2), Cell::ALIVE),
                new Cell(new CellId(2, 3), Cell::ALIVE),
                new Cell(new CellId(3, 1), Cell::DEAD),
                new Cell(new CellId(3, 2), Cell::DEAD),
                new Cell(new CellId(3, 3), Cell::ALIVE),
            )
        );

        $actual = $this->resolver->resolveNextStage($collection);
        $this->assertTrue($actual->findCellById(new CellId(2, 2))->isAlive());
    }

    public function test_live_cells_with_three_live_neighbors_should_survive()
    {
        /**
         * ---
         * -**
         * -**
         */
        $collection = new CellCollection(
            array(
                new Cell(new CellId(1, 1), Cell::DEAD),
                new Cell(new CellId(1, 2), Cell::DEAD),
                new Cell(new CellId(1, 3), Cell::DEAD),
                new Cell(new CellId(2, 1), Cell::DEAD),
                new Cell(new CellId(2, 2), Cell::ALIVE),
                new Cell(new CellId(2, 3), Cell::ALIVE),
                new Cell(new CellId(3, 1), Cell::DEAD),
                new Cell(new CellId(3, 2), Cell::ALIVE),
                new Cell(new CellId(3, 3), Cell::ALIVE),
            )
        );

        $actual = $this->resolver->resolveNextStage($collection);
        $this->assertTrue($actual->findCellById(new CellId(2, 2))->isAlive());
    }

    public function test_live_cells_with_more_than_3_neighbors_should_die_of_overpopulation()
    {
        /**
         * ---
         * -**
         * ***
         */
        $collection = new CellCollection(
            array(
                new Cell(new CellId(1, 1), Cell::DEAD),
                new Cell(new CellId(1, 2), Cell::DEAD),
                new Cell(new CellId(1, 3), Cell::DEAD),
                new Cell(new CellId(2, 1), Cell::DEAD),
                new Cell(new CellId(2, 2), Cell::ALIVE),
                new Cell(new CellId(2, 3), Cell::ALIVE),
                new Cell(new CellId(3, 1), Cell::ALIVE),
                new Cell(new CellId(3, 2), Cell::ALIVE),
                new Cell(new CellId(3, 3), Cell::ALIVE),
            )
        );

        $actual = $this->resolver->resolveNextStage($collection);
        $this->assertTrue($actual->findCellById(new CellId(2, 2))->isDead());
    }

    public function test_dead_cells_with_three_live_neighbors_should_be_reborn()
    {
        /**
         * ---
         * --*
         * -**
         */
        $collection = new CellCollection(
            array(
                new Cell(new CellId(1, 1), Cell::DEAD),
                new Cell(new CellId(1, 2), Cell::DEAD),
                new Cell(new CellId(1, 3), Cell::DEAD),
                new Cell(new CellId(2, 1), Cell::DEAD),
                new Cell(new CellId(2, 2), Cell::DEAD),
                new Cell(new CellId(2, 3), Cell::ALIVE),
                new Cell(new CellId(3, 1), Cell::DEAD),
                new Cell(new CellId(3, 2), Cell::ALIVE),
                new Cell(new CellId(3, 3), Cell::ALIVE),
            )
        );

        $actual = $this->resolver->resolveNextStage($collection);
        $this->assertTrue($actual->findCellById(new CellId(2, 2))->isAlive());
    }
}
