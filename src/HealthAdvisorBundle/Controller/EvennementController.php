<?php

namespace HealthAdvisorBundle\Controller;

use HealthAdvisorBundle\Entity\Evennement;
use HealthAdvisorBundle\Form\EvennementType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EvennementController extends Controller
{
    public function ajoutEvenementAction(Request $request)
    {
        $evenement = new Evennement();
        $form = $this->createForm(EvennementType::class, $evenement);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $evenement->setValidation("Non-défini");
            $evenement->setCreateur("brehima");
            $em->persist($evenement);
            $em->flush();
            return $this->redirectToRoute('listEvt');
        }
        return $this->render('@HealthAdvisor/Evenement/ajout.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function listEvtAction()
    {
        $req = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Evennement');
        $tab = $req->findAll();
        return $this->render('@HealthAdvisor/Evenement/list.html.twig', array('evt' => $tab));
    }

    public function deleteEvtAction($id)
    {
        $evenement = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Evennement')->find($id);
        $req = $this->getDoctrine()->getManager();
        $req->remove($evenement);
        $req->flush();
        return $this->redirectToRoute('listEvt');
    }

    public function modifEvtAction(Request $request, $id)
    {
        $evenement = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Evennement')->find($id);
        $form = $this->createForm(EvennementType::class, $evenement);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($evenement);
            $em->flush();
            return $this->redirectToRoute('listEvt');
        }
        return $this->render('@HealthAdvisor/Evenement/ajout.html.twig', array('form' => $form->createView()));

    }
}
