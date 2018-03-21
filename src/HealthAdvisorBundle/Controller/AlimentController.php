<?php

namespace HealthAdvisorBundle\Controller;

use HealthAdvisorBundle\Entity\Aliment;
use HealthAdvisorBundle\Entity\Type_Aliment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Aliment controller.
 *
 * @Route("admin/")
 */
class AlimentController extends Controller
{

    public function afficherAlimentAction()
    {
        $em = $this->getDoctrine()->getManager();

        $aliments = $em->getRepository('HealthAdvisorBundle:Aliment')->findAll();

        return $this->render('@HealthAdvisor/Admin_Template/Biennetre_back/afficherAliment.html.twig', array(
            'aliments' => $aliments,
        ));
    }


    public function ajouterAlimentAction(Request $request)
    {
        $aliment = new Aliment();

        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod('POST'))
        {
            $tab = (array)$request->get('typeAliment');
            $aliment->setNomAliment($request->get('nomAliment'));
            $aliment->setQuantite($request->get('quantite'));
            $aliment->setTypeAliment(implode(" ",$tab));
            $aliment->setValeurEnergetique($request->get('valeurEnergetique'));
            $em->persist($aliment);
            $em->flush();
            return $this->redirectToRoute('afficher_aliment', array('nomAliment' => $aliment->getNomaliment()));
        }

        return $this->render('@HealthAdvisor/Admin_Template/Biennetre_back/ajouterAliment.html.twig', array(
         "typeAliment"=>Type_Aliment::$type_aliment
        ));
    }


    public function rechercheAlimentAction(Aliment $aliment)
    {
        $deleteForm = $this->createDeleteForm($aliment);

        return $this->render('aliment/show.html.twig', array(
            /*'aliment' => $aliment,
            'delete_form' => $deleteForm->createView(),*/
        ));
    }


    public function modifierAlimentAction(Request $request, Aliment $aliment)
    {
        $editForm = $this->createForm('HealthAdvisorBundle\Form\AlimentType', $aliment);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('', array('nomAliment' => $aliment->getNomaliment()));
        }

        return $this->render('@HealthAdvisor/Admin_Template/Biennetre_back/ajouterAliment.html.twig', array(
            'aliment' => $aliment,
            'edit_form' => $editForm->createView()
        ));
    }


    public function supprimerAlimentAction(Request $request)
    {

        if ($request->get('nomAliment') !="") {
            $aliment = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Aliment')
                ->find($request->get('nomAliment'));
            $em = $this->getDoctrine()->getManager();
            $em->remove($aliment);
            $em->flush();
        }

        return $this->redirectToRoute('afficher_aliment');
    }


}
