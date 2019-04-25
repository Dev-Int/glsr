<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="_home", methods={"GET"})
     */
    public function index()
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * Get FamilyLog.
     *
     * @Route("/getfamilylog", name="getfamilylog", methods={"POST"})
     *
     * @param \Symfony\Component\HttpFoundation\Request $request Post request
     */
    public function getFamilyLog(Request $request): Response
    {
        $return = new Response('Error');
        $etm = $this->getDoctrine()->getManager();
        if ($request->isXmlHttpRequest()) {
            $familyLog = [];
            $id = $request->get('id');
            if ('' !== $id) {
                $supplier = $etm
                    ->getRepository('App:Settings\Supplier')
                    ->find($id);
                $familyLog['familylog'] = $supplier->getFamilyLog()->getId();
                $response = new Response();
                $data = \json_encode($familyLog);
                $response->headers->set('Content-Type', 'application/json');
                $response->setContent($data);
                $return = $response;
            }
        }

        return $return;
    }
}
