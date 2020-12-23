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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

final class AppContext implements Context
{
    private KernelInterface $kernel;
    private ?Response $response = null;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @When enter company data for :uri url
     *
     * @throws \Exception
     */
    public function enterCompanyData(string $uri, TableNode $table): bool
    {
        $content = [];
        $data = $table->getRow(1);
        $keys = $table->getRow(0);
        for ($i = 0, $iMax = \count($data); $i < $iMax; ++$i) {
            $content['company'][$keys[$i]] = $data[$i];
        }

        $this->response = $this->kernel->handle(Request::create(
            $uri,
            Request::METHOD_POST,
            ['body' => $content]
        ));

        return true;
    }

    /**
     * @When enter user data for :uri url
     *
     * @throws \Exception
     */
    public function enterUserData(string $uri, TableNode $table): bool
    {
        $content = [];
        $data = $table->getRow(1);
        $keys = $table->getRow(0);
        for ($i = 0, $iMax = \count($data); $i < $iMax; ++$i) {
            $content['user'][$keys[$i]] = $data[$i];
        }

        $this->response = $this->kernel->handle(Request::create(
            $uri,
            Request::METHOD_POST,
            ['body' => $content]
        ));

        return true;
    }

    /**
     * @Then return status code :arg1
     */
    public function returnStatusCode(int $arg1): bool
    {
        if (null === $this->response) {
            throw new \RuntimeException("Expected status code: {$arg1}");
        }

        return ($arg1 === $this->response->getStatusCode()) ?? false;
    }
}
