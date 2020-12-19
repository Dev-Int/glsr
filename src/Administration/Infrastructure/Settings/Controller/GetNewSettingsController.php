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

namespace Administration\Infrastructure\Settings\Controller;

use Administration\Infrastructure\Settings\Form\Type\SettingsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class GetNewSettingsController extends AbstractController
{
    public function __invoke(): Response
    {
        $form = $this->createForm(SettingsType::class, null, [
            'action' => $this->generateUrl('admin_settings_configure'),
        ]);

        return $this->render('Administration/Settings/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
