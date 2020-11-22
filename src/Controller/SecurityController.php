<?php

namespace App\Controller;

use App\Entity\Staff\User2;
use App\Form\Type\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

final class SecurityController extends AbstractController
{
    /**
     * @Route("/subscribtion", name="security_registration")
     */
    public function registration(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User2();
        $form = $this->createForm(RegistrationType::class, $user, ['roles' => $this->getExistingRoles(),]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);
            $user->setIsActive(true);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('securityLogin');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/connexion", name="securityLogin")
     */
    public function login(): Response
    {
        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/deconnexion", name="securityLogout")
     */
    public function logout(): void
    {
    }

    private function getExistingRoles(): array
    {
        $roleHierarchy = $this->getParameter('security.role_hierarchy.roles');
        $roles = array_keys($roleHierarchy);
        $theRoles = array();

        foreach ($roles as $role) {
            $theRoles[$role] = $role;
        }
        return $theRoles;
    }
}
