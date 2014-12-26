<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

use Star\GameOfLife\World;
use PHPUnit_Framework_Assert as Assert;

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{
    /**
     * @var Star\GameOfLife\World
     */
    private $world;

    /**
     * @var string
     */
    private $output;

    /**
     * @var string
     */
    private $liveCell;

    /**
     * @var string
     */
    private $deadCell;

    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
    }

    /**
     * @Given /^The live cell representation is \'([^\']*)\'$/
     */
    public function theLiveCellRepresentationIs($string)
    {
        $this->liveCell = $string;
    }

    /**
     * @Given /^The dead cell representation is \'([^\']*)\'$/
     */
    public function theDeadCellRepresentationIs($string)
    {
        $this->deadCell = $string;
    }

    /**
     * @Given /^I have the following world:$/
     */
    public function iHaveTheFollowingWorld(TableNode $table)
    {
        $this->world = World::fromArray($table->getHash());
    }

    /**
     * @When /^I run the simulation$/
     */
    public function iRunTheSimulation()
    {
        $this->output = $this->world->run();
    }

    /**
     * @Then /^The world should look like:$/
     */
    public function theWorldShouldLookLike(PyStringNode $string)
    {
        var_dump($string->getLines());
        Assert::assertSame($string->getRaw(), $this->output);
    }

    /**
     * @Given /^The iteration count should be (\d+)$/
     */
    public function theIterationCountShouldBe($iterationCount)
    {
        Assert::assertSame($iterationCount, $this->world->iteration());
    }
}
