<?php
/**
 * This file is part of the game-life project.
 *
 * (c) Yannick Voyer (http://github.com/yvoyer)
 */

namespace Star\GameOfLife;

use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ConsoleRenderer
 *
 * @author  Yannick Voyer (http://github.com/yvoyer)
 *
 * @package Star\GameOfLife
 */
final class ConsoleRenderer implements CellRenderer
{
    const CLASS_NAME = __CLASS__;

    /**
     * @var StateResolver
     */
    private $resolver;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @param StateResolver   $resolver
     * @param OutputInterface $output
     */
    public function __construct(StateResolver $resolver, OutputInterface $output)
    {
        $this->resolver = $resolver;
        $this->output = $output;
    }

    /**
     * @param Cell $cell
     *
     * @return string
     */
    public function render(Cell $cell)
    {
        return $this->resolver->resolveContent($cell);
    }

    /**
     * @return string
     */
    public function renderLineFeed()
    {
        return "\n";
    }

    /**
     * @param CellCollection $line
     *
     * @return string
     */
    public function renderLine(CellCollection $line)
    {
        $string = '';
        foreach ($line as $column) {
            $string .= $this->render($column);
        }

        $this->output->writeln($string);

        return $string;
    }
}
