<?php

declare(strict_types=1);

namespace Behat\Tests;

use Inventory\Domain\Model\Article;
use Inventory\Domain\Model\Articles;
use Inventory\Domain\Model\Inventory;
use Inventory\Domain\Model\User;
use Inventory\Domain\Model\VO\InventoryDate;
use Inventory\Domain\UseCase\EnterInventory;
use Inventory\Domain\UseCase\PrepareInventory;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;

/**
 * Defines application features from the specific context.
 */
final class InventoryContext implements Context
{
    private Inventory $inventory;
    private User $user;
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
     * @Given I am a user
     */
    public function thereIsAUser(TableNode $table): void
    {
        foreach ($table as $row) {
            $this->user = User::create($row['username'], $row['email'], $row['role']);
        }
    }

    /**
     * @Given I am an :role
     */
    public function asRole(string $role): void
    {
        Assert::assertSame($this->user->role(), $role);
    }

    /**
     * @Given there is an articles list
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
    public function itSTheLastDayOf(TableNode $table):void
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
     * @When I want to enter quantities
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
    public function iShouldSeeTheListOfGapsOrderedByGaps(TableNode $table, string $order):void
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
}
