<?php
/**
 * This file is part of the game-life project.
 *
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\GameOfLife;

/**
 * Class StateResolverTest
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\GameOfLife
 */
final class StateResolverTest extends \PHPUnit_Framework_TestCase
{
    const CLASS_NAME = __CLASS__;

    /**
     * @var StateResolver
     */
    private $resolver;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $cell;

    public function setUp()
    {
        $this->cell = $this->getMockBuilder(Cell::CLASS_NAME)
            ->disableOriginalConstructor()
            ->getMock();

        $this->resolver = new StateResolver();
    }

    public function test_should_support_default_cell_status()
    {
        $this->assertSame(Cell::DEAD, $this->resolver->resolveStatus(' '));
        $this->assertSame(Cell::ALIVE, $this->resolver->resolveStatus('*'));
    }

    public function test_should_support_configurable_cell_status()
    {
        $this->resolver->setDeadCellOutput('_');
        $this->resolver->setLiveCellOutput('=');

        $this->assertSame(Cell::DEAD, $this->resolver->resolveStatus('_'));
        $this->assertSame(Cell::ALIVE, $this->resolver->resolveStatus('='));
    }

    /**
     * @expectedException        \LogicException
     * @expectedExceptionMessage The dead and live string can't be the same.
     */
    public function test_should_throw_exception_on_same_configuration_when_setting_live_output()
    {
        $this->resolver->setDeadCellOutput('_');
        $this->resolver->setLiveCellOutput('_');
    }

    /**
     * @expectedException        \LogicException
     * @expectedExceptionMessage The dead and live string can't be the same.
     */
    public function test_should_throw_exception_on_same_configuration_when_setting_dead_output()
    {
        $this->resolver->setLiveCellOutput('_');
        $this->resolver->setDeadCellOutput('_');
    }

    /**
     * @expectedException        \LogicException
     * @expectedExceptionMessage Content '342' did not match any status.
     */
    public function test_should_throw_exception_when_unable_to_resolver()
    {
        $this->resolver->resolveStatus('342');
    }

    public function test_should_resolve_alive_content()
    {
        $this->cell
            ->expects($this->once())
            ->method('isAlive')
            ->will($this->returnValue(true));

        $this->assertSame('*', $this->resolver->resolveContent($this->cell));
    }

    public function test_should_resolve_content()
    {
        $this->cell
            ->expects($this->once())
            ->method('isDead')
            ->will($this->returnValue(true));

        $this->assertSame(' ', $this->resolver->resolveContent($this->cell));
    }

    /**
     * @expectedException        \LogicException
     * @expectedExceptionMessage No content mapping was found for cell state.
     */
    public function test_should_throw_exception_when_unable_to_resolve_content()
    {
        $this->resolver->resolveContent($this->cell);
    }
}
