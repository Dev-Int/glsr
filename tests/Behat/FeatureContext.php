<?php

declare(strict_types=1);

namespace Tests\Behat;

use App\Inventory\Domain\Article;
use App\Inventory\Domain\Articles;
use App\Inventory\Domain\Inventory;
use App\Inventory\Domain\User;
use App\Inventory\Domain\VO\InventoryDate;
use App\Inventory\Infrastructure\InventoryController;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;

/**
 * Defines application features from the specific context.
 */
final class FeatureContext implements Context
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
        $articles = [];
        foreach ($table as $item) {
            $articles[] = Article::create(
                $item['label'],
                (float) $item['theoreticalStock'],
                (float) $item['price']
            );
        }
        $this->articles = new Articles($articles);
    }

    /**
     * @Given the date is the last day of
     *
     * @throws \Exception
     */
    public function itSTheLastDayOf(TableNode $table):void
    {
        foreach ($table as $row) {
            if ('month' === $row['test']) {
                Assert::assertSame($row['date'], date("Y-m-t", strtotime($row['date'])));
                $this->date = new \DateTimeImmutable($row['date']);
            }
            if ('week' === $row['test']) {
                Assert::assertSame('Sunday', date_format(date_create($row['date']), 'l'));
                $this->date = new \DateTimeImmutable($row['date']);
            }
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
        $this->inventory = (new InventoryController())->prepare($this->date);
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
    public function iShouldSeeArticlesList(TableNode $articleList): void
    {
        Assert::assertIsArray($this->inventory->articles()->toArray());
        Assert::assertEquals($this->articles->toArray(), $this->inventory->articles()->toArray());
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
        foreach ($table as $row) {
            foreach ($this->articles->toArray() as $article) {
                if ($article->label() === $row['label']) {
                    $this->inventory->enterInventoriedQuantity(
                        $article,
                        $row['stock']
                    );
                }
            }
        }
    }

    /**
     * @Then I should see the list of gaps
     */
    public function iShouldSeeTheListOfGaps(TableNode $table):void
    {
        $expectedGaps = [];
        foreach ($table as $item) {
            $expectedGaps[] = ['label' => $item['label'], 'gap' => $item['gap'], 'amount' => $item['amount']];
        }
        $gaps = $this->inventory->getGaps();

        Assert::assertSame($expectedGaps, $gaps);
    }
}
