<?php
/**
 * This file is part of the game-life project.
 *
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\GameOfLife;

/**
 * Class WorldTest
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\GameOfLife
 */
final class WorldTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var World
     */
    private $world;

    public function setUp()
    {
        $this->world = new World(array(new Cell(new CellId(1, 2), Cell::ALIVE)), new StubLifeResolver());
    }

    public function test_should_have_size()
    {
        $this->assertSame(1, $this->world->size());
    }

    public function test_should_return_cell_content()
    {
        $cellRenderer = $this->getMockCellRenderer();
        $cellRenderer
            ->expects($this->once())
            ->method('render')
            ->will($this->returnValue('*'));

        $this->assertSame('*', $this->world->getContent(new CellId(1, 2), $cellRenderer));
    }

    public function test_should_increase_iteration()
    {
        $this->assertSame(0, $this->world->iteration());
        $this->world->run($this->getMockCellRenderer());
        $this->assertSame(1, $this->world->iteration());
        $this->world->run($this->getMockCellRenderer());
        $this->assertSame(2, $this->world->iteration());
        $this->world->run($this->getMockCellRenderer());
        $this->assertSame(3, $this->world->iteration());
    }

    public function test_should_be_constructed_by_factory()
    {
        $array = array(
            array(
                '',
                '*',
                '*',
            ),
            array(
                '*',
                '',
                '*',
            ),
        );

        $resolver = new StateResolver();
        $resolver->setDeadCellOutput('');
        $resolver->setLiveCellOutput('*');

        $this->world = World::fromArray($array, $resolver);
        $this->assertSame(6, $this->world->size());
    }

    public function test_should_return_output()
    {
        $this->world = new World(
            array(
                new Cell(new CellId(1, 1), Cell::ALIVE),
                new Cell(new CellId(1, 2), Cell::ALIVE),
                new Cell(new CellId(2, 1), Cell::ALIVE),
                new Cell(new CellId(2, 2), Cell::ALIVE),
            ),
            new StubLifeResolver()
        );

        $expected = <<<STRING
**_**_
STRING;

        $cellRenderer = $this->getMockCellRenderer();
        $cellRenderer
            ->expects($this->any())
            ->method('render')
            ->will($this->returnValue('*'));
        $cellRenderer
            ->expects($this->any())
            ->method('renderLineFeed')
            ->will($this->returnValue('_'));

        $this->assertSame($expected, $this->world->run($cellRenderer));
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getMockCellRenderer()
    {
        return $this->getMock(CellRenderer::INTERFACE_NAME);
    }
}

class StubLifeResolver extends LifeResolver
{
    public function resolveNextStage(CellCollection $collection)
    {
        return $collection;
    }
}
