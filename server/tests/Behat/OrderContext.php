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
use Order\Domain\Exception\SupplierNotFound;
use Order\Domain\Model\Article;
use Order\Domain\Model\Articles;
use Order\Domain\Model\Order;
use Order\Domain\Model\Supplier;
use Order\Domain\Model\Suppliers;
use Order\Domain\Model\VO\OrderDate;
use Order\Domain\UseCase\CreateOrder;
use Order\Domain\UseCase\EnterOrder;
use PHPUnit\Framework\Assert;

final class OrderContext implements Context
{
    private Suppliers $suppliers;
    private Supplier $supplier;
    private Order $order;
    private Articles $articles;
    private \DateTimeImmutable $date;

    /**
     * @Given there is a suppliers list
     */
    public function thereIsASuppliersList(TableNode $table): void
    {
        $this->suppliers = new Suppliers();
        foreach ($table as $row) {
            $this->suppliers->add(Supplier::create(
                $row['name'],
                $row['address'],
                $row['email'],
                \array_map('intval', \explode(',', $row['orderDays']))
            ));
        }
    }

    /**
     * @Given there is an articles list for order
     *
     * @throws SupplierNotFound
     */
    public function thereIsAnArticlesList(TableNode $table): void
    {
        $this->articles = new Articles();
        foreach ($table as $item) {
            $this->articles->add(Article::create(
                $item['label'],
                $this->suppliers->getFromName($item['supplier']),
                (float) $item['quantity'],
                (float) $item['quantityToOrder'],
                (float) $item['minimumStock'],
                (float) $item['price']
            ));
        }
    }

    /**
     * @When I have to choose the supplier
     *
     * @throws SupplierNotFound
     */
    public function iChoiceTheSupplier(TableNode $table): void
    {
        foreach ($table as $row) {
            $this->supplier = $this->suppliers->getFromName($row['name']);
        }
    }

    /**
     * @When I have to choose the order date
     *
     * @throws \Exception
     */
    public function iHaveToChooseTheOrderDate(TableNode $table): void
    {
        foreach ($table as $row) {
            $this->date = OrderDate::fromDate(
                new \DateTimeImmutable($row['date']),
                $this->supplier->orderDays()
            )->getValue();
        }
        if (null === $this->date) {
            return;
        }
    }

    /**
     * @When I want to create an order
     */
    public function iWantToCreateAnOrder(): void
    {
        $this->order = (new CreateOrder())->execute($this->supplier, $this->date);
    }

    /**
     * @Then I should see the list of supplier articles
     */
    public function iShouldSeeTheListOfSupplierArticles(TableNode $table): void
    {
        $supplier = '';
        foreach ($table as $item) {
            $supplier = $item['supplier'];
        }
        $articleList = \array_filter($this->articles->toArray(), static function (Article $article) use ($supplier) {
            return $supplier === $article->supplier()->name();
        });
        Assert::assertIsArray($this->order->articles()->toArray());
        Assert::assertEquals($articleList, $this->order->articles()->toArray());
    }

    /**
     * @Given  an order exist
     */
    public function anOrderExist(): void
    {
        $this->order = (new CreateOrder())->execute($this->supplier, $this->date);
    }

    /**
     * @When I enter order quantities
     */
    public function iEnterOrderQuantities(TableNode $table): void
    {
        $data = [];
        foreach ($table as $row) {
            $data[] = ['label' => $row['label'], 'quantityToOrder' => (float) $row['quantityToOrder']];
        }

        (new EnterOrder())->execute($this->order, $data);
    }
}
