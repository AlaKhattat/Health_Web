<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 23/03/2018
 * Time: 13:12
 */

namespace HealthAdvisorBundle\Controller;


use HealthAdvisorBundle\Entity\InformationSante;
use HealthAdvisorBundle\Entity\Patient;
use HealthAdvisorBundle\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BiennetreController extends Controller
{
    public function indexOutilBiennetreAction(Request $request)
    {
        $informationSante = new Informationsante();
        $form = $this->createForm('HealthAdvisorBundle\Form\InformationSanteType', $informationSante);
     //   var_dump($this->container->get('security.token_storage')->getToken()->getUsername());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            if($this->container->get('security.token_storage')->getToken()->getUsername()!=null)
            {
              var_dump($this->container->get('security.token_storage')->getToken());
                $patient = new Patient();
                /*$patient=$this->getDoctrine()->getRepository("HealthAdvisorBundle:Patient")
                          ->find($this->container->get('security.token_storage')->getToken()->getUsername());*/
                $patient->setCinUser($this->container->get('security.token_storage')->getToken()->getUser());
                var_dump($patient->getCinUser()->getId());
                var_dump($patient->setLogin($patient->getCinUser()->getCin()));
                $patient->setPassword($patient->getCinUser()->getPassword());
                //var_dump($patient);
                echo ("hh");
                $informationSante->setLogin($patient);

                $em->persist($informationSante);
                $em->flush();
            }

            /*a mediter encore */
            // return $this->redirectToRoute('', array('login' => $informationSante->getLogin()));
        }

        return $this->render('HealthAdvisorBundle:Default/Biennetre_front:outilsBiennetre.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    public function ajouterInfoSanteAction(Request $request)
    {
        $informationSante = new Informationsante();
      var_dump($informationSante);

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