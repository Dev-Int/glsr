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
use Glsr\GestockBundle\Entity\Company;
use Glsr\GestockBundle\Form\CompanyType;

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
     * @return Response
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
     * @return Response
     */
    public function addAction()
    {
        if (!$this->get('security.context')->isGranted('ROLE_ADMIN')) {
            // On définit un message flash
            $this->get('session')
                ->getFlashBag()
                ->add(
                    'info',
                    'Vous devez être connecté pour accéder à cette page.'
                );

            // On redirige vers la page de connexion
            return $this->redirect(
                $this->generateUrl(
                    'fos_user_security_login'
                )
            );
        }
        $company = new Company();

        $form = $this->createForm(new CompanyType(), $company);

        // On récupère la requête
        $request = $this->getRequest();

        // On vérifie qu'elle est de type POST
        if ($request->getMethod() == 'POST') {
            // On fait le lien Requête <-> Formulaire
            $form->bind($request);

            // On vérifie que les valeurs rentrées sont correctes
            if ($form->isValid()) {
                // On enregistre l'objet $article dans la base de données
                $etm = $this->getDoctrine()->getManager();
                $etm->persist($company);
                $etm->flush();

                // On définit un message flash
                $this->get('session')
                    ->getFlashBag()
                    ->add('info', 'Company bien ajoutée');

                // On redirige vers la page de visualisation
                // des configuration de l'appli
                return $this->redirect($this->generateUrl('glstock_company'));
            }
        }

        return $this->render(
            'GlsrGestockBundle:Gestock/Settings:add.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    /**
     * Modifier l'entreprise.
     *
     * @param Company $company Entreprise à modifier
     *
     * @return type
     */
    public function editAction(Company $company)
    {
        if (!$this->get('security.context')->isGranted('ROLE_ADMIN')) {
            // On définit un message flash
            $this->get('session')
                ->getFlashBag()
                ->add(
                    'info',
                    'Vous devez être connecté pour accéder à cette page.'
                );

            // On redirige vers la page de connexion
            return $this->redirect(
                $this->generateUrl(
                    'fos_user_security_login'
                )
            );
        }
        // On utilise le SettingsType
        $form = $this->createForm(new CompanyType(), $company);

        $request = $this->getRequest();

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
                    ->add('info', 'Company bien modifié');

                return $this->redirect($this->generateUrl('glstock_company'));
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