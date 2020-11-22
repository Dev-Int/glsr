<?php

namespace App\Controller;

use App\Entity\Settings\Diverse\FamilyLog;
use App\Entity\Settings\Supplier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction(): Response
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/getfamilylog", name="getfamilylog", methods="POST")
     */
    public function getFamilyLogAction(Request $request): Response
    {
        $etm = $this->getDoctrine()->getManager();

        /** @var FamilyLog[] $familyLogs */
        $familyLogs = $etm->getRepository('App:Settings\Diverse\FamilyLog')->findAll();


        $return = new Response('Error');

        if ($request->isXmlHttpRequest()) {
            $familyLog = [];
            $id = $request->get('id');

            /** @var Supplier $supplier */
            $supplier = $etm->getRepository('App:Settings\Supplier')->find($id);
            $familyLog['id'] = $supplier->getFamilyLog()->getId();
            if ($id !== '') {
                // Add directs children of $familyLog
                $familyLog = $this->getSubFamily($familyLogs, $familyLog);

                $response = new Response();
                $data = json_encode($familyLog);
                $response->headers->set('Content-Type', 'application/json');
                $response->setContent($data);
                $return = $response;
            }
        }
        return $return;
    }

    /**
     * Get the SubFamily of Supplier.
     *
     * @param FamilyLog[] $familyLogs
     */
    protected function getSubFamily(array $familyLogs, array $familyLog): array
    {
        $testFamily = '';
        foreach ($familyLogs as $family) {
            if ($family->getId() === $familyLog['id']) {
                $testFamily = $family;
            }
        }
        if ($testFamily->getLevel() === 2) {
            $familyLog['family']['id'] = $testFamily->getId();
            $familyLog['family']['name'] = $testFamily->getIndentedName();
            $key = 0;
            foreach ($familyLogs as $family) {
                if ($family->getParent() !== null && $family->getParent()->getId() === $familyLog['id']) {
                    $familyLog['family'][$key]['id'] = $family->getId();
                    $familyLog['family'][$key]['name'] = $family->getIndentedName();
                    $key++;
                }
            }
        }
        return $familyLog;
    }
}
