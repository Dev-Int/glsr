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

namespace Company\UI\Controller;

use Company\Domain\Storage\ReadCompany;
use Core\Controller\AbstractController;
use Core\Infrastructure\Response\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class GetCompany extends AbstractController
{
    private JsonResponse $jsonResponse;
    private ReadCompany $readCompany;

    public function __construct(
        ReadCompany $readCompany,
        SerializerInterface $serializer,
        JsonResponse $jsonResponse
    ) {
        parent::__construct($serializer);

        $this->jsonResponse = $jsonResponse;
        $this->readCompany = $readCompany;
    }

    public function __invoke(string $uuid): Response
    {
        $company = $this->readCompany->findOneByUuid($uuid);

        return $this->jsonResponse->response($this->serialize($company));
    }
}
