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

    public function setUp()
    {
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
}
