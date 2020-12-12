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
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

final class InventoryContext implements Context
{
    private KernelInterface $kernel;
    private ?Response $response;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @When I visit page :path
     *
     * @throws \Exception
     */
    public function iVisitPage(string $path): bool
    {
        $this->response = $this->kernel->handle(Request::create($path, Request::METHOD_GET));

        $responseCode = $this->response->getStatusCode();

        if (200 !== $responseCode) {
            throw new \RuntimeException('Expected a 200, but received' . $responseCode);
        }

        return true;
    }

    /**
     * @Then it should return a :file
     */
    public function itShouldReturnFile(string $format): bool
    {
        if (false === ($this->response instanceof BinaryFileResponse)) {
            throw new \RuntimeException('Expected format"' . $format . '"');
        }

        return true;
    }
}
