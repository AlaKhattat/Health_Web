<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 23/03/2018
 * Time: 13:12
 */

namespace HealthAdvisorBundle\Controller;


use HealthAdvisorBundle\Entity\InformationSante;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BiennetreController extends Controller
{
    public function indexOutilBiennetreAction()
    {
        $informationSante = new Informationsante();
        $form = $this->createForm('HealthAdvisorBundle\Form\InformationSanteType', $informationSante);
       return  $this->render("HealthAdvisorBundle:Default/Biennetre_front:outilsBiennetre.html.twig",
                                 array('form' => $form->createView()) );
    }


    public function ajouterInfoSanteAction(Request $request)
    {
        $informationSante = new Informationsante();
        $form = $this->createForm('HealthAdvisorBundle\Form\InformationSanteType', $informationSante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($informationSante);
            $em->flush();
          /*a mediter encore */
           // return $this->redirectToRoute('', array('login' => $informationSante->getLogin()));
        }

        return $this->render('HealthAdvisorBundle:Default/Biennetre_front:outilsBiennetre.html.twig', array(
            'informationSante' => $informationSante,
            'form' => $form->createView(),
        ));
    }

    public function afficherInfoSanteAction(Request $request)
    {

        $informationSante = $this->getDoctrine()->getRepository('HealthAdvisorBundle:InformationSante')->find($request);
        if($informationSante!=null)
        {
            return $this->render('informationsante/show.html.twig', array(
                'informationSante' => $informationSante,
            ));
        }
        else
        {
            $informationSante = new InformationSante();
        }

        return $this->render('HealthAdvisorBundle:Default/Biennetre_front:outilsBiennetre.html.twig', array(
            'informationSante' => $informationSante,
        ));
    }

    public function editAction(Request $request, InformationSante $informationSante)
    {
        $editForm = $this->createForm('HealthAdvisorBundle\Form\InformationSanteType', $informationSante);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('', array('login' => $informationSante->getLogin()));
        }

        return $this->render('HealthAdvisorBundle:Default/Biennetre_front:outilsBiennetre.html.twig', array(
            'informationSante' => $informationSante
        ));
    }




}