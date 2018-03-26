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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class BiennetreController extends Controller
{
    public function indexOutilBiennetreAction(Request $request)
    {
        $informationSante = new Informationsante();
        $imc=0;
        $interpretationIMC="";
        $form = $this->createForm('HealthAdvisorBundle\Form\InformationSanteType', $informationSante);
       if($request->isXmlHttpRequest()) {


           $form->handleRequest($request);

           if ($request->get('taille')!=null&&$request->get('age')!=null) {
               $em = $this->getDoctrine()->getManager();
               if ($this->container->get('security.token_storage')->getToken()->getUsername() != "anon.") {
                   $patient = new Patient();
                   $patient = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Patient')->findOneBy(array('cinUser'=>$this->container->get('security.token_storage')->getToken()->getUser()));
                   $informationSante = $this->getDoctrine()->getRepository('HealthAdvisorBundle:InformationSante')->find($patient->getLogin());
                   if($informationSante==null)
                   {
                       $informationSante = new InformationSante();
                   }
                   $informationSante->setAge($request->get('age'));
                   $informationSante->setPoids($request->get('poids'));
                   $informationSante->setSexe($request->get('sexe'));
                   $informationSante->setTaille($request->get('taille'));
                   $informationSante->setLogin($patient);
                   $em->persist($informationSante);
                   $em->flush();
                   $imc = $informationSante->calculIMC($informationSante);
                   $interpretationIMC = $informationSante->interpreterIMC($imc);
                   $serializer = new Serializer(array(new ObjectNormalizer()));
                   $tableau = array("imc"=>$imc,"interpretation"=>$interpretationIMC);
                   $resultat = $serializer->normalize($tableau);
                   return new JsonResponse($resultat);
               } else {
                   $informationSante->setAge($request->get('age'));
                   $informationSante->setPoids($request->get('poids'));
                   $informationSante->setSexe($request->get('sexe'));
                   $informationSante->setTaille($request->get('taille'));
                   $imc = $informationSante->calculIMC($informationSante);
                   $interpretationIMC = $informationSante->interpreterIMC($imc);
                   $serializer = new Serializer(array( new ObjectNormalizer()));
                   $tableau = array("imc"=>$imc,"interpretation"=>$interpretationIMC);
                   $resultat = $serializer->normalize($tableau);
                   return new JsonResponse($resultat);

               }

               /*a mediter encore */
               // return $this->redirectToRoute('', array('login' => $informationSante->getLogin()));
           }
       }


        return $this->render('HealthAdvisorBundle:Default/Biennetre_front:outilsBiennetre.html.twig', array(
            'form' => $form->createView(),'imc'=>$imc,'interpretationIMC'=>$interpretationIMC
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