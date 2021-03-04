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
use Inventory\Domain\Model\User;
use PHPUnit\Framework\Assert;

final class FeatureContext implements Context
{
    private User $user;

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
}
