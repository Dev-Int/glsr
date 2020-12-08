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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class CompanyContext implements Context
{
    private HttpClientInterface $client;
    private ResponseInterface $response;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @When enter data:
     *
     * @throws TransportExceptionInterface
     */
    public function enterData(TableNode $table): bool
    {
        $content = [];
        $data = $table->getRow(1);
        $keys = $table->getRow(0);
        for ($i = 0, $iMax = \count($data); $i < $iMax; ++$i) {
            $content['create_company'][$keys[$i]] = $data[$i];
        }

        $this->response = $this->client->request(
            'POST',
            '/administration/company/create',
            [
                'body' => $content,
                'base_uri' => 'https://127.0.0.1:8000',
                'verify_peer' => false,
                'verify_host' => false,
            ]
        );

        return JsonResponse::HTTP_ACCEPTED === $this->response->getStatusCode();
    }

    /**
     * @Then return status code :arg1
     *
     * @throws TransportExceptionInterface
     */
    public function returnStatusCode(int $arg1): bool
    {
        return $arg1 === $this->response->getStatusCode();
    }
}
