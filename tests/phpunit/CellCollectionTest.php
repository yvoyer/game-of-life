<?php
/**
 * This file is part of the game-life project.
 *
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\GameOfLife;

/**
 * Class CellCollectionTest
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\GameOfLife
 */
final class CellCollectionTest extends \PHPUnit_Framework_TestCase
{
    const CLASS_NAME = __CLASS__;

    /**
     * @var CellCollection
     */
    private $collection;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $cell1;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $cell2;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $cell3;

    public function setUp()
    {
        $this->cell1 = $this->getMockCell();
        $this->cell1
            ->expects($this->any())
            ->method('id')
            ->will($this->returnValue(new CellId(1, 1)));

        $this->cell2 = $this->getMockCell();
        $this->cell2
            ->expects($this->any())
            ->method('id')
            ->will($this->returnValue(new CellId(1, 2)));

        $this->cell3 = $this->getMockCell();
        $this->cell3
            ->expects($this->any())
            ->method('id')
            ->will($this->returnValue(new CellId(3, 1)));

        $this->collection = new CellCollection(
            array(
                $this->cell1,
                $this->cell2,
                $this->cell3,
            )
        );
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockCell()
    {
        return $this->getMockBuilder(Cell::CLASS_NAME)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function test_should_return_cell_by_id()
    {
        $id = new CellId(1, 2);

        $this->assertSame($this->cell2, $this->collection->findCellById($id));
        $this->assertNull($this->collection->findCellById(new CellId(321,312)));
    }

    public function test_should_return_the_cells_of_row()
    {
        $expected = array(
            $this->cell1,
            $this->cell2,
        );

        $this->assertSame($expected, $this->collection->findCellsOfRow(1));
    }

    public function test_should_return_size()
    {
        $this->assertSame(3, $this->collection->size());
    }

    public function test_should_return_alive_cells()
    {
        $expected = array(
            $this->cell2,
        );

        $this->cell2
            ->expects($this->once())
            ->method('isAlive')
            ->will($this->returnValue(true));

        $actual = $this->collection->findAliveCells();
        $this->assertCount(count($expected), $actual);
        $this->assertSame($expected, $actual);
    }

    public function test_should_return_neighbors_of_cell()
    {
        $expected = array(
            $this->cell1,
            $this->cell2,
        );

        $this->cell1
            ->expects($this->once())
            ->method('isNeighbour')
            ->will($this->returnValue(true));

        $this->cell2
            ->expects($this->once())
            ->method('isNeighbour')
            ->will($this->returnValue(true));

        $actual = $this->collection->findNeighborsCells(new CellId(1, 2));
        $this->assertCount(count($expected), $actual);
        $this->assertSame($expected, $actual);
    }
}
