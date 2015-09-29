<?php

/**
 * CompanyController controller de la configuration de l'entreprise.
 *
 * PHP Version 5
 *
 * @author     Quétier Laurent <lq@dev-int.net>
 * @copyright  2014 Dev-Int GLSR
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @version    GIT: a4408b1f9fc87a1f93911d80e8421fef1bd96cab
 *
 * @link       https://github.com/GLSR/glsr
 */
namespace Glsr\GestockBundle\Controller\Settings;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Glsr\GestockBundle\Entity\Company;
use Glsr\GestockBundle\Form\Type\CompanyType;

/**
 * class CompanyController.
 *
 * @category   Controller
 */
class CompanyController extends Controller
{
    /**
     * Affiche les données de l'entreprise.
     *
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function showAction()
    {
        $etm = $this->getDoctrine()->getManager();
        $repoCompany = $etm->getRepository('GlsrGestockBundle:Company');
        $company = $repoCompany->findAll();

        return $this->render(
            'GlsrGestockBundle:Gestock/Settings:index.html.twig',
            array('company' => $company)
        );
    }
    
    /**
     * Crée les données de l'entreprise.
     *
     * @return Symfony\Component\HttpFoundation\Response
     *
     * @throws AccessDeniedException
     */
    public function addshowAction()
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $company = new Company();

        $form = $this->createForm(new CompanyType(), $company);

        return $this->render(
            'GlsrGestockBundle:Gestock/Settings:add.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Crée les données de l'entreprise.
     *
     * @return Symfony\Component\HttpFoundation\Response
     *
     * @throws AccessDeniedException
     */
    public function addProcessAction(Request $request)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        $company = new Company();

        $form = $this->createForm(new CompanyType(), $company);

        // On fait le lien Requête <-> Formulaire
        $form->submit($request);

        // On vérifie que les valeurs rentrées sont correctes
        if ($form->isValid()) {
            // On enregistre l'objet $article dans la base de données
            $etm = $this->getDoctrine()->getManager();
            $etm->persist($company);
            $etm->flush();
           $url = $this->generateUrl('glstock_application_add');
            $message = "glsr.gestock.settings.add_ok";
        } else {
            $url = $this->generateUrl('glstock_company_add');
            $message = "glsr.gestock.settings.add_no";
        }
        // On définit un message flash
        $this->get('session')->getFlashBag()->add('info', $message);
        // On redirige vers la page de visualisation
        //  de l'article nouvellement créé
        return $this->redirect($url);
    }

    /**
     * Modifier l'entreprise.
     *
     * @param Company $company Entreprise à modifier
     *
     * @return type
     *
     * @throws AccessDeniedException
     */
    public function editAction(Company $company, Request $request)
    {
        if (false === $this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }
        // On utilise le SettingsType
        $form = $this->createForm(new CompanyType(), $company);

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                // On enregistre la config
                $etm = $this->getDoctrine()->getManager();
                $etm->persist($company);
                $etm->flush();

                // On définit un message flash
                $this->get('session')
                    ->getFlashBag()
                    ->add('info', 'glsr.gestock.settings.edit_ok');

                return $this->redirect($this->generateUrl('glstock_company_show'));
            }
        }

        return $this->render(
            'GlsrGestockBundle:Gestock/Settings:edit.html.twig',
            array(
                'form' => $form->createView(),
                'company' => $company,
            )
        );
    }
}
