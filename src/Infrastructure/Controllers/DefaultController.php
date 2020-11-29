<?php

declare(strict_types=1);

namespace Infrastructure\Controllers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     */
    public function __invoke(): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'Controller',
        ]);
    }
}
