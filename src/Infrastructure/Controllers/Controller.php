<?php

declare(strict_types=1);

namespace Infrastructure\Controllers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class Controller extends AbstractController
{
    /**
     * @Route("/", name="_home")
     */
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'Controller',
        ]);
    }
}
