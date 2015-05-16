<?php

/**
 * SettingsController controller de la configuration du Bundle Gestock.
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
namespace Glsr\GestockBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Glsr\GestockBundle\Entity\Settings;
use Glsr\GestockBundle\Entity\Tva;
use Glsr\GestockBundle\Entity\Company;
use Glsr\GestockBundle\Entity\FamilyLog;
use Glsr\GestockBundle\Entity\SubFamilyLog;
use Glsr\GestockBundle\Entity\ZoneStorage;
use Glsr\GestockBundle\Entity\UnitStorage;
use Glsr\GestockBundle\Form\SettingsType;
use Glsr\GestockBundle\Form\TvaType;
use Glsr\GestockBundle\Form\CompanyType;
use Glsr\GestockBundle\Form\FamilyLogType;
use Glsr\GestockBundle\Form\SubFamilyLogType;
use Glsr\GestockBundle\Form\ZoneStorageType;
use Glsr\GestockBundle\Form\UnitStorageType;

/**
 * class SettingsController.
 *
 * @category   Controller
 */
class SettingsController extends Controller
{
    /**
     * Affiche les données de l'entreprise.
     *
     * @return Response
     */
    public function showCompanyAction()
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
     * Affiche les paramètres de base de l'application.
     *
     * @return Response
     */
    public function showApplicationAction()
    {
        $etm = $this->getDoctrine()->getManager();
        $repoSettings = $etm->getRepository('GlsrGestockBundle:Settings');
        $settings = $repoSettings->findAll();

        return $this->render(
            'GlsrGestockBundle:Gestock/Settings:index.html.twig',
            array('settings' => $settings)
        );
    }

    /**
     * Affiche les paramètres divers de l'application.
     *
     * @return Response
     */
    public function showDiversAction()
    {
        $etm = $this->getDoctrine()->getManager();
        $subFamilyLog = $etm
            ->getRepository('GlsrGestockBundle:SubFamilyLog')
            ->findAll();

        $zoneStorage = $etm
            ->getRepository('GlsrGestockBundle:ZoneStorage')
            ->findAll();

        $unitStorage = $etm
            ->getRepository('GlsrGestockBundle:UnitStorage')
            ->findAll();

        $tva = $etm->getRepository('GlsrGestockBundle:Tva')->findAll();

        return $this->render(
            'GlsrGestockBundle:Gestock/Settings:index.html.twig',
            array(
                'divers' => 1,
                'subfamilylog' => $subFamilyLog,
                'zonestorage' => $zoneStorage,
                'unitstorage' => $unitStorage,
                'tva' => $tva,
            )
        );
    }

    /**
     * Ajouter un paramètre.
     *
     * @return Response
     */
    public function addSettingsAction()
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
        $settings = new Settings();

        $form = $this->createForm(new SettingsType(), $settings);

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
                $etm->persist($settings);
                $etm->flush();

                // On définit un message flash
                $this->get('session')
                    ->getFlashBag()
                    ->add('info', 'Configuration bien ajoutée');

                // On redirige vers la page de visualisation
                // des configuration de l'appli
                return $this->redirect(
                    $this->generateUrl(
                        'glstock_application'
                    )
                );
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
     * Modifier les paramètres de base de l'application.
     *
     * @param \Glsr\GestockBundle\Entity\Settings $settings
     * Objet de l'entité Settings à modifier
     *
     * @return Response
     */
    public function editSettingsAction(Settings $settings)
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
        $form = $this->createForm(new SettingsType(), $settings);

        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                // On enregistre la config
                $etm = $this->getDoctrine()->getManager();
                $etm->persist($settings);
                $etm->flush();

                // On définit un message flash
                $this->get('session')
                    ->getFlashBag()
                    ->add('info', 'Configuration bien modifié');

                return $this->redirect(
                    $this->generateUrl(
                        'glstock_application'
                    )
                );
            }
        }

        return $this->render(
            'GlsrGestockBundle:Gestock/Settings:edit.html.twig',
            array(
            'form' => $form->createView(),
            'settings' => $settings,
            )
        );
    }

    /**
     * Crée les données de l'entreprise.
     *
     * @return Response
     */
    public function addCompanyAction()
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
    public function editCompanyAction(Company $company)
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

    /**
     * Ajouter une famille logistique.
     *
     * @return Response
     */
    public function addFamilyLogAction()
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
        $familyLog = new FamilyLog();

        $form = $this->createForm(new FamilyLogType(), $familyLog);

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
                $etm->persist($familyLog);
                $etm->flush();

                // On définit un message flash
                $this->get('session')
                    ->getFlashBag()
                    ->add('info', 'FamilyLog bien ajoutée');

                // On redirige vers la page de visualisation
                // des configuration de l'appli
                return $this->redirect($this->generateUrl('glstock_divers'));
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
     * editFamilyLogAction Modifier une famille logistique.
     *
     * @param FamilyLog $familyLog Objet famille logistique à modifier
     *
     * @return type
     */
    public function editFamilyLogAction(FamilyLog $familyLog)
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
        $form = $this->createForm(new FamilyLogType(), $familyLog);

        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                // On enregistre la config
                $etm = $this->getDoctrine()->getManager();
                $etm->persist($familyLog);
                $etm->flush();

                // On définit un message flash
                $this->get('session')
                    ->getFlashBag()
                    ->add('info', 'FamilyLog bien modifié');

                return $this->redirect($this->generateUrl('glstock_divers'));
            }
        }

        return $this->render(
            'GlsrGestockBundle:Gestock/Settings:edit.html.twig',
            array(
                'form' => $form->createView(),
                'familylog' => $familyLog,
            )
        );
    }

    /**
     * Ajouter une sous-famille logistique.
     *
     * @return Response
     */
    public function addSubFamilyLogAction()
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
        $subFamilyLog = new SubFamilyLog();

        $form = $this->createForm(new SubFamilyLogType(), $subFamilyLog);

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
                $etm->persist($subFamilyLog);
                $etm->flush();

                // On définit un message flash
                $this->get('session')
                    ->getFlashBag()
                    ->add('info', 'SubFamilyLog bien ajoutée');

                // On redirige vers la page de visualisation
                // des configuration de l'appli
                return $this->redirect($this->generateUrl('glstock_divers'));
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
     * Modifier une sous-famille logistique.
     *
     * @param SubFamilyLog $subFamilyLog Objet subfamily logistique à modifier
     *
     * @return type
     */
    public function editSubFamilyLogAction(SubFamilyLog $subFamilyLog)
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
        $form = $this->createForm(new SubFamilyLogType(), $subFamilyLog);

        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                // On enregistre la config
                $etm = $this->getDoctrine()->getManager();
                $etm->persist($subFamilyLog);
                $etm->flush();

                // On définit un message flash
                $this->get('session')
                    ->getFlashBag()
                    ->add('info', 'SubFamilyLog bien modifié');

                return $this->redirect($this->generateUrl('glstock_divers'));
            }
        }

        return $this->render(
            'GlsrGestockBundle:Gestock/Settings:edit.html.twig',
            array(
                'form' => $form->createView(),
                'subfamilylog' => $subFamilyLog,
            )
        );
    }

    /**
     * Ajouter une zone de stockage.
     *
     * @return Response
     */
    public function addZoneStorageAction()
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
        $zoneStorage = new ZoneStorage();

        $form = $this->createForm(new ZoneStorageType(), $zoneStorage);

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
                $etm->persist($zoneStorage);
                $etm->flush();

                // On définit un message flash
                $this->get('session')
                    ->getFlashBag()
                    ->add('info', 'ZoneStorage bien ajoutée');

                // On redirige vers la page de visualisation
                // des configuration de l'appli
                return $this->redirect($this->generateUrl('glstock_divers'));
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
     * Modifier une zone de stockage.
     *
     * @param ZoneStorage $zoneStorage Objet zone de stockage à modifier
     *
     * @return Response
     */
    public function editZoneStorageAction(ZoneStorage $zoneStorage)
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
        $form = $this->createForm(new ZoneStorageType(), $zoneStorage);

        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                // On enregistre la config
                $etm = $this->getDoctrine()->getManager();
                $etm->persist($zoneStorage);
                $etm->flush();

                // On définit un message flash
                $this->get('session')
                    ->getFlashBag()
                    ->add('info', 'ZoneStorage bien modifié');

                return $this->redirect($this->generateUrl('glstock_divers'));
            }
        }

        return $this->render(
            'GlsrGestockBundle:Gestock/Settings:edit.html.twig',
            array(
                'form' => $form->createView(),
                'zonestorage' => $zoneStorage,
            )
        );
    }

    /**
     * Ajouter une unité de stockage.
     *
     * @return Response
     */
    public function addUnitStorageAction()
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
        $unitStorage = new UnitStorage();

        $form = $this->createForm(new UnitStorageType(), $unitStorage);

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
                $etm->persist($unitStorage);
                $etm->flush();

                // On définit un message flash
                $this->get('session')
                    ->getFlashBag()
                    ->add('info', 'UnitStorage bien ajoutée');

                // On redirige vers la page de visualisation
                // des configuration de l'appli
                return $this->redirect($this->generateUrl('glstock_divers'));
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
     * Modifier une unité de stockage.
     *
     * @param UnitStorage $unitStorage Objet unité de stockage à modifier
     *
     * @return Response
     */
    public function editUnitStorageAction(UnitStorage $unitStorage)
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
        $form = $this->createForm(new UnitStorageType(), $unitStorage);

        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                // On enregistre la config
                $etm = $this->getDoctrine()->getManager();
                $etm->persist($unitStorage);
                $etm->flush();

                // On définit un message flash
                $this->get('session')
                    ->getFlashBag()
                    ->add('info', 'UnitStorage bien modifié');

                return $this->redirect($this->generateUrl('glstock_divers'));
            }
        }

        return $this->render(
            'GlsrGestockBundle:Gestock/Settings:edit.html.twig',
            array(
                'form' => $form->createView(),
                'unitstorage' => $unitStorage,
            )
        );
    }

    /**
     * Ajouter une TVA.
     *
     * @return Response
     */
    public function addTvaAction()
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
        $tva = new Tva();

        $form = $this->createForm(new TvaType(), $tva);

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
                $etm->persist($tva);
                $etm->flush();

                // On définit un message flash
                $this->get('session')
                    ->getFlashBag()
                    ->add('info', 'Tva bien ajoutée');

                // On redirige vers la page de visualisation des
                // configuration de l'appli
                return $this->redirect($this->generateUrl('glstock_divers'));
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
     * Modifier une TVA.
     *
     * @param Tva $tva objet TVA à modifier
     *
     * @return Response
     */
    public function editTvaAction(Tva $tva)
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
        $form = $this->createForm(new TvaType(), $tva);

        $request = $this->getRequest();

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                // On enregistre la config
                $etm = $this->getDoctrine()->getManager();
                $etm->persist($tva);
                $etm->flush();

                // On définit un message flash
                $this->get('session')
                    ->getFlashBag()
                    ->add('info', 'Tva bien modifié');

                return $this->redirect($this->generateUrl('glstock_divers'));
            }
        }

        return $this->render(
            'GlsrGestockBundle:Gestock/Settings:edit.html.twig',
            array(
                'form' => $form->createView(),
                'tva' => $tva,
            )
        );
    }
}
