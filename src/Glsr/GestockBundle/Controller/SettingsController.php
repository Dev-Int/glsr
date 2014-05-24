<?php

namespace Glsr\GestockBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;

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
 * Description of SettingsController
 *
 * @author Laurent
 */
class SettingsController extends Controller
{
    public function indexAction()
    {
        $etm = $this->getDoctrine()->getManager();
        $repoSettings = $etm->getRepository('GlsrGestockBundle:Settings');
        $settings = $repoSettings->findAll();
        
        $repoCompany = $etm->getRepository('GlsrGestockBundle:Company');
        $company = $repoCompany->findAll();
        if (empty($company)) {
            // On définit un message flash
            $this->get('session')->getFlashBag()->add('info', 'Il faut renseigner les informations de la société');
            // On redirige vers la page d'ajout d'information de la société
            return $this->redirect($this->generateUrl('glstock_company_add'));
        }
        
        $repoSubFamilyLog = $etm->getRepository('GlsrGestockBundle:SubFamilyLog');
        $subFamilyLog = $repoSubFamilyLog->findAll();
        
        $repoZoneStorage = $etm->getRepository('GlsrGestockBundle:ZoneStorage');
        $zoneStorage = $repoZoneStorage->findAll();
        
        $repoUnitStorage = $etm->getRepository('GlsrGestockBundle:UnitStorage');
        $unitStorage = $repoUnitStorage->findAll();
        
        $repoTva = $etm->getRepository('GlsrGestockBundle:Tva');
        $tva = $repoTva->findAll();
        
        /**
         * @todo Créer la page d'accueil Settings, pour les 3 possibilités de configurations
         */
        return $this->render('GlsrGestockBundle:Gestock/Settings:index.html.twig', array(
            'settings'     => $settings,
            'company'      => $company,
            'subfamilylog' => $subFamilyLog,
            'zonestorage'  => $zoneStorage,
            'unitstorage'  => $unitStorage,
            'tva'          => $tva
        ));
    }
    
    public function addSettingsAction()
    {
        $settings = new Settings();
        $tva      = new Tva();
        
        $form = $this->createForm(new SettingsType(), $settings);
        $form .= $this->createForm(new TvaType, $tva);
        
        // On récupère la requête
        $request = $this->getRequest();

        // On vérifie qu'elle est de type POST
        if ($request->getMethod() == 'POST') {
            // On fait le lien Requête <-> Formulaire
            $form->bind($request);

            // On vérifie que les valeurs rentrées sont correctes
            if ($form->isValid()) {
                // On enregistre l'objet $article dans la base de données
                $em = $this->getDoctrine()->getManager();
                $em->persist($settings);
                $em->flush();                

                // On définit un message flash
                $this->get('session')->getFlashBag()->add('info', 'Configuration bien ajoutée');

                // On redirige vers la page de visualisation des configuration de l'appli
                return $this->redirect($this->generateUrl('glstock_settings'));
            }
        }

        // À ce stade :
        // - soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
        // - soit la requête est de type POST, mais le formulaire n'est pas valide, donc on l'affiche de nouveau

        return $this->render('GlsrGestockBundle:Gestock/Settings:add.html.twig', array(
          'form' => $form->createView(),
        ));
    }
    
    function editSettingsAction(Settings $settings)
    {
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
                $this->get('session')->getFlashBag()->add('info', 'Configuration bien modifié');

                return $this->redirect($this->generateUrl('glstock_settings'));
            }
        }

        return $this->render('GlsrGestockBundle:Gestock/Settings:edit.html.twig', array(
          'form'    => $form->createView(),
          'settings' => $settings
        ));
    }

    public function addCompanyAction()
    {
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
                $this->get('session')->getFlashBag()->add('info', 'Company bien ajoutée');

                // On redirige vers la page de visualisation des configuration de l'appli
                return $this->redirect($this->generateUrl('glstock_settings'));
            }
        }

        // À ce stade :
        // - soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
        // - soit la requête est de type POST, mais le formulaire n'est pas valide, donc on l'affiche de nouveau

        return $this->render('GlsrGestockBundle:Gestock/Settings:add.html.twig', array(
          'form' => $form->createView(),
        ));
    }
    
    function editCompanyAction(Company $company)
    {
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
                $this->get('session')->getFlashBag()->add('info', 'Company bien modifié');

                return $this->redirect($this->generateUrl('glstock_settings'));
            }
        }

        return $this->render('GlsrGestockBundle:Gestock/Settings:edit.html.twig', array(
          'form'    => $form->createView(),
          'company' => $company
        ));
    }

    public function addFamilyLogAction()
    {
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
                $this->get('session')->getFlashBag()->add('info', 'FamilyLog bien ajoutée');

                // On redirige vers la page de visualisation des configuration de l'appli
                return $this->redirect($this->generateUrl('glstock_settings'));
            }
        }

        // À ce stade :
        // - soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
        // - soit la requête est de type POST, mais le formulaire n'est pas valide, donc on l'affiche de nouveau

        return $this->render('GlsrGestockBundle:Gestock/Settings:add.html.twig', array(
          'form' => $form->createView(),
        ));
    }
    
    function editFamilyLogAction(FamilyLog $familyLog)
    {
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
                $this->get('session')->getFlashBag()->add('info', 'FamilyLog bien modifié');

                return $this->redirect($this->generateUrl('glstock_settings'));
            }
        }

        return $this->render('GlsrGestockBundle:Gestock/Settings:edit.html.twig', array(
          'form'    => $form->createView(),
          'familylog' => $familyLog
        ));
    }

    public function addSubFamilyLogAction()
    {
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
                $this->get('session')->getFlashBag()->add('info', 'SubFamilyLog bien ajoutée');

                // On redirige vers la page de visualisation des configuration de l'appli
                return $this->redirect($this->generateUrl('glstock_settings'));
            }
        }

        // À ce stade :
        // - soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
        // - soit la requête est de type POST, mais le formulaire n'est pas valide, donc on l'affiche de nouveau

        return $this->render('GlsrGestockBundle:Gestock/Settings:add.html.twig', array(
          'form' => $form->createView(),
        ));
    }
    
    function editSubFamilyLogAction(SubFamilyLog $subFamilyLog)
    {
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
                $this->get('session')->getFlashBag()->add('info', 'SubFamilyLog bien modifié');

                return $this->redirect($this->generateUrl('glstock_settings'));
            }
        }

        return $this->render('GlsrGestockBundle:Gestock/Settings:edit.html.twig', array(
          'form'    => $form->createView(),
          'subfamilylog' => $subFamilyLog
        ));
    }

    public function addZoneStorageAction()
    {
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
                $this->get('session')->getFlashBag()->add('info', 'ZoneStorage bien ajoutée');

                // On redirige vers la page de visualisation des configuration de l'appli
                return $this->redirect($this->generateUrl('glstock_settings'));
            }
        }

        // À ce stade :
        // - soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
        // - soit la requête est de type POST, mais le formulaire n'est pas valide, donc on l'affiche de nouveau

        return $this->render('GlsrGestockBundle:Gestock/Settings:add.html.twig', array(
          'form' => $form->createView(),
        ));
    }
    
    function editZoneStorageAction(ZoneStorage $zoneStorage)
    {
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
                $this->get('session')->getFlashBag()->add('info', 'ZoneStorage bien modifié');

                return $this->redirect($this->generateUrl('glstock_settings'));
            }
        }

        return $this->render('GlsrGestockBundle:Gestock/Settings:edit.html.twig', array(
          'form'    => $form->createView(),
          'zonestorage' => $zoneStorage
        ));
    }
    
    public function addUnitStorageAction()
    {
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
                $this->get('session')->getFlashBag()->add('info', 'UnitStorage bien ajoutée');

                // On redirige vers la page de visualisation des configuration de l'appli
                return $this->redirect($this->generateUrl('glstock_settings'));
            }
        }

        // À ce stade :
        // - soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
        // - soit la requête est de type POST, mais le formulaire n'est pas valide, donc on l'affiche de nouveau

        return $this->render('GlsrGestockBundle:Gestock/Settings:add.html.twig', array(
          'form' => $form->createView(),
        ));
    }
    
    function editUnitStorageAction(UnitStorage $unitStorage)
    {
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
                $this->get('session')->getFlashBag()->add('info', 'UnitStorage bien modifié');

                return $this->redirect($this->generateUrl('glstock_settings'));
            }
        }

        return $this->render('GlsrGestockBundle:Gestock/Settings:edit.html.twig', array(
          'form'    => $form->createView(),
          'unitstorage' => $unitStorage
        ));
    }
    
    public function addTvaAction()
    {
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
                $this->get('session')->getFlashBag()->add('info', 'Tva bien ajoutée');

                // On redirige vers la page de visualisation des configuration de l'appli
                return $this->redirect($this->generateUrl('glstock_settings'));
            }
        }

        // À ce stade :
        // - soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
        // - soit la requête est de type POST, mais le formulaire n'est pas valide, donc on l'affiche de nouveau

        return $this->render('GlsrGestockBundle:Gestock/Settings:add.html.twig', array(
          'form' => $form->createView(),
        ));
    }
    
    function editTvaAction(Tva $tva)
    {
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
                $this->get('session')->getFlashBag()->add('info', 'Tva bien modifié');

                return $this->redirect($this->generateUrl('glstock_settings'));
            }
        }

        return $this->render('GlsrGestockBundle:Gestock/Settings:edit.html.twig', array(
          'form'    => $form->createView(),
          'tva' => $tva
        ));
    }
}
