<?php

declare(strict_types=1);

/*
 * This file is part of the G.L.S.R. Apps package.
 *
 * (c) Dev-Int Création <info@developpement-interessant.com>.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Behat\Tests;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Inventory\Domain\Model\Article;
use Inventory\Domain\Model\Articles;
use Inventory\Domain\Model\Inventory;
use Inventory\Domain\Model\VO\InventoryDate;
use Inventory\Domain\UseCase\EnterInventory;
use Inventory\Domain\UseCase\PrepareInventory;
use Inventory\Domain\UseCase\ValidInventory;
use PHPUnit\Framework\Assert;

/**
 * Defines application features from the specific context.
 */
final class InventoryContext implements Context
{
    private Inventory $inventory;
    private \DateTimeImmutable $date;
    private Articles $articles;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @Given there is an articles list for inventory
     */
    public function thereIsAnArticlesList(TableNode $table): void
    {
        $this->articles = new Articles();
        foreach ($table as $item) {
            $this->articles->add(Article::create(
                $item['label'],
                (float) $item['theoreticalStock'],
                (float) $item['price']
            ));
        }
    }

    /**
     * @Given the date is the last day of
     *
     * @throws \Exception
     */
    public function itSTheLastDayOf(TableNode $table): void
    {
        foreach ($table as $row) {
            $this->date = InventoryDate::fromDate(new \DateTimeImmutable($row['date']))->getValue();
        }
        if (null === $this->date) {
            return;
        }
    }

    /**
     * @When I want to prepare an inventory
     */
    public function iWantTo(): void
    {
        $this->inventory = (new PrepareInventory())->execute($this->date);
    }

    /**
     * @Given order by
     */
    public function orderBy(TableNode $table): void
    {
        foreach ($table as $row) {
            $orders[] = $row;
        }
    }

    /**
     * @Then I should see the list of articles
     */
    public function iShouldSeeArticlesList(TableNode $table): void
    {
        $articleList = [];
        foreach ($table as $item) {
            $articleList[] = Article::create($item['label'], (float) $item['theoreticalStock'], (float) $item['price']);
        }
        Assert::assertIsArray($this->inventory->articles()->toArray());
        Assert::assertEquals($articleList, $this->inventory->articles()->toArray());
    }

    /**
     * @Given an inventory exist
     */
    public function anInventoryExist(): void
    {
        $this->inventory = Inventory::prepare(
            InventoryDate::fromDate($this->date),
            $this->articles
        );
        Assert::assertInstanceOf(
            Inventory::class,
            $this->inventory
        );
    }

    /**
     * @When I want to enter inventory quantities
     */
    public function iWantToEnterQuantities(TableNode $table): void
    {
        $data = [];
        foreach ($table as $row) {
            $data[] = $row;
        }

        (new EnterInventory())->execute($this->inventory, $data);
    }

    /**
     * @Then I should see the list of gaps ordered by :gaps
     */
    public function iShouldSeeTheListOfGapsOrderedByGaps(TableNode $table, string $order): void
    {
        $expectedGaps = [];
        foreach ($table as $item) {
            $expectedGaps[] = ['label' => $item['label'], 'gap' => (float) $item['gap'], 'amount' => (float) $item['amount']];
        }
        $gaps = $this->inventory->getGaps($order);

        Assert::assertSame($expectedGaps, $gaps);
    }

    /**
     * @When I see bad gaps
     */
    public function iSeeBadGaps(): void
    {
    }

    /**
     * @Given I correct the needed quantities
     */
    public function iCorrectTheNeededQuantities(TableNode $table): void
    {
        $data = [];
        foreach ($table as $row) {
            $data[] = $row;
        }

        (new EnterInventory())->execute($this->inventory, $data);
    }

    /**
     * @Then the gaps are valid
     */
    public function theGapsAreValid(TableNode $table): void
    {
        $expectedGaps = [];
        foreach ($table as $item) {
            $expectedGaps[] = ['label' => $item['label'], 'gap' => (float) $item['gap'], 'amount' => (float) $item['amount']];
        }
        $gaps = $this->inventory->getGaps();

        Assert::assertSame($expectedGaps, $gaps);
    }

    /**
     * @When I valid the inventory
     */
    public function iValidTheInventory(): void
    {
        (new ValidInventory())->execute($this->inventory);
    }

    /**
     * @Then the quantity of articles is updated
     */
    public function theQuantityOfArticlesIsUpdated(TableNode $table): void
    {
        $articles = new Articles();
        foreach ($table as $item) {
            $articles->add(Article::create(
                $item['label'],
                (float) $item['theoreticalStock'],
                (float) $item['price']
            ));
        }

        Assert::assertEquals($articles->toArray(), $this->inventory->articles()->toArray());
    }
}
