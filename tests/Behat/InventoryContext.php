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
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class InventoryContext implements Context
{
    private HttpClientInterface $client;
    private ResponseInterface $response;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @When I visit page :arg1
     *
     * @throws TransportExceptionInterface
     */
    public function iVisitPage(string $arg1): bool
    {
        $this->response = $this->client->request('GET', $arg1, ['verify_peer' => false, 'verify_host' => false]);

        $responseCode = $this->response->getStatusCode();

        if (200 !== $responseCode) {
            throw new \RuntimeException('Expected a 200, but received' . $responseCode);
        }

        return true;
    }

    /**
     * @Then it should return a file with title :arg1
     */
    public function itShouldReturnFileWithPdfExtension(string $arg1): bool
    {
        if ($arg1 !== $this->response->getContent()) {
            throw new \RuntimeException('Expected title "Inventaire"');
        }

        return true;
    }
}
