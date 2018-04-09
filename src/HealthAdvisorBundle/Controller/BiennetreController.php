<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 23/03/2018
 * Time: 13:12
 */

namespace HealthAdvisorBundle\Controller;


use HealthAdvisorBundle\Entity\Aliment;
use HealthAdvisorBundle\Entity\InformationSante;
use HealthAdvisorBundle\Entity\Nutritionix;
use HealthAdvisorBundle\Entity\Patient;
use HealthAdvisorBundle\Entity\ProgrammeRegime;
use HealthAdvisorBundle\Entity\Regime;
use HealthAdvisorBundle\Entity\Type_Aliment;
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
        $informationSantePoid= new InformationSante();
        $imc=0;
        $poidIdeal=0;
        $interpretationIMC="";
        $tableau =array();
        $serializer = new Serializer(array(new ObjectNormalizer()));
        $form = $this->createForm('HealthAdvisorBundle\Form\InformationSanteType', $informationSante);
        $formPoidIdeal = $this->createForm('HealthAdvisorBundle\Form\poidIdealType',$informationSantePoid);

       if($request->isXmlHttpRequest()) {

           $form->handleRequest($request);
           $formPoidIdeal->handleRequest($request);
           if ($request!=null) {

               $em = $this->getDoctrine()->getManager();
               if ($this->container->get('security.token_storage')->getToken()->getUsername() != "anon.") {
                   $patient = new Patient();
                   $patient = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Patient')->findOneBy(array('cinUser'=>$this->container->get('security.token_storage')->getToken()->getUser()));
                   $informationSante = $this->getDoctrine()->getRepository('HealthAdvisorBundle:InformationSante')->find($patient->getLogin());
                   if($informationSante==null)
                   {
                       $informationSante = new InformationSante();
                   }
                   if($request->get('action')=='calculIMC')
                   {
                       $informationSante->setAge($request->get('age'));
                       $informationSante->setPoids($request->get('poids'));
                       $informationSante->setSexe($request->get('sexe'));
                       $informationSante->setTaille($request->get('taille'));
                       $imc = $informationSante->calculIMC($informationSante);
                       $interpretationIMC = $informationSante->interpreterIMC($imc);
                       $tableau = array("imc"=>$imc,"interpretation"=>$interpretationIMC);
                       $informationSante->setLogin($patient);
                       $em->persist($informationSante);
                       $em->flush();
                   }
                   else if($request->get('action')=='calculPoidIdeal')
                   {

                       $informationSantePoid->setSexe($request->get('sexe'));
                       $informationSantePoid->setTaille($request->get('taille'));
                       $poidIdeal = $informationSantePoid->calculPoidIdeal($informationSante);

                       $tableau = array("poidsIdeal"=>$poidIdeal);
                       $informationSantePoid->setLogin($patient);
                     //  $em->persist($informationSantePoid);
                       //$em->flush();
                   }

                   $resultat = $serializer->normalize($tableau);
                   return new JsonResponse($resultat);
               } else {

                   if($request->get('action')=='calculIMC')
                   {
                       $informationSante->setAge($request->get('age'));
                       $informationSante->setPoids($request->get('poids'));
                       $informationSante->setSexe($request->get('sexe'));
                       $informationSante->setTaille($request->get('taille'));
                       $imc = $informationSante->calculIMC($informationSante);
                       $interpretationIMC = $informationSante->interpreterIMC($imc);
                       $tableau = array("imc"=>$imc,"interpretation"=>$interpretationIMC);
                   }
                   else if($request->get('action')=='calculPoidIdeal')
                   {
                       $informationSantePoid->setSexe($request->get('sexe'));
                       $informationSantePoid->setTaille($request->get('taille'));
                       $poidIdeal = $informationSantePoid->calculPoidIdeal($informationSantePoid);
                       $tableau = array("poidIdeal"=>$poidIdeal);
                   }

                   $resultat = $serializer->normalize($tableau);
                   return new JsonResponse($resultat);

               }

           }
       }

        return $this->render('HealthAdvisorBundle:Default/Biennetre_front:outilsBiennetre.html.twig', array(
            'form' => $form->createView(),'formPoidIdeal'=>$formPoidIdeal->createView(),'imc'=>$imc,'interpretationIMC'=>$interpretationIMC,'poidIdeal'=>$poidIdeal
        ));
    }


    public function ajouterInfoSanteAction(Request $request)
    {
        $informationSante = new Informationsante();
      var_dump($informationSante);

    }

    public function calculCalorieAction(Request $request)
    {
        if($request->isXmlHttpRequest())
        {
            if($request->get('aliment')!="")
            {
                $nutrition = new Nutritionix("073b261f","b9bfaaaff31fc9b51481c649d2958a6f");
                $serializer = new Serializer(array(new ObjectNormalizer()));
                $nom = $request->get('aliment');
               $resultat= $serializer->normalize($nutrition->search("'".$nom."'",NULL,0,10,NULL,1,NULL,
                    'item_name,brand_name,item_id,nf_calories',TRUE,FALSE));
               return  new JsonResponse($resultat);
            }

        }
        return $this->render('@HealthAdvisor/Default/Biennetre_front/calculCalorie.html.twig');
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

    public function suivreRegimeAction(Request $request)
    {
        $patient = new Patient();
        $poidIdeal = 0;
        $informationSante = new InformationSante();
        $patient = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Patient')->findOneBy(array('cinUser'=>$this->container->get('security.token_storage')->getToken()->getUser()));
        $informationSante = $this->getDoctrine()->getRepository('HealthAdvisorBundle:InformationSante')->find($patient->getLogin());
        if($informationSante!=null)
        {
            $poidIdeal = $informationSante->calculPoidIdeal($informationSante);
        }
        return $this->render('HealthAdvisorBundle:Default/Biennetre_front:suivreRegime.html.twig',array("info"=>$informationSante,
                                                                                                              "poidIdeal"=>$poidIdeal
        ));
    }

    public function proposerRegimeAction(Request $request)
    {
        if($request->isXmlHttpRequest())
        {
            $programmeRegime = new ProgrammeRegime();
            $a = new Aliment();
            $listRegime = new Aliment();
            //'age': age,'taille':taille,'poids':poids,'poidsAperdre':poidsAperdre,'allergies':allergies,'allergiesSupp':allergiesSupp,'maladiesSupp':maladiesSupp
            $age = $request->get('age');
            $taille = $request->get('taille');
            $poids = $request->get('poids');
            $poidsAPerdre = $request->get('poidsAperdre');
            $allergies = $request->get('allergies');
            $allergiesSupp = $request->get('allergiesSupp');
            $maladiesSupp = $request->get('maladiesSupp');
            $aliments = new Aliment();
            $aliments = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Aliment')->findAll();
          //  echo $aliments[0]->getNomAliment();
            //var_dump($aliments[0]->getIdRegime()->getValues());
            $allergies = Type_Aliment::returnArrayTypeAliment($allergies);
            $aliments=$programmeRegime->trieAlergiesAliment($aliments,$allergies);
            $listRegime = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Regime')->findAll();
            $regimes= array();
           foreach ($aliments as  $aliment)
            {
                foreach ($aliment->getIdRegime()->toArray() as  $regime)
                {
                    if(sizeof($regimes)==0)
                    {
                        $reg = new Regime();
                        $reg->setIdRegime($regime->getIdRegime());
                        $reg->getNomAliment()->add($aliment);
                        $reg = array($regime->getIdRegime() => $reg);
                        array_push($regimes,$reg);
                        //var_dump($regimes);
                    }
                    else
                    {
                        if(array_key_exists($regime->getIdRegime(),$regimes)==false)
                        {
                            $reg = new Regime();
                            $reg->setIdRegime($regime->getIdRegime());
                            $reg->getNomAliment()->add($aliment);
                            $reg = array($regime->getIdRegime() => $reg);
                            array_push($regimes,$reg);
                        }
                        else {
                           echo "hjnk,lm";
                        }
                    }

                   /* echo  $regime->getIdRegime()."<br>";
                    if(sizeof($regimes)>0) {

                        if (array_key_exists($regime->getIdRegime(), $regimes[0])) {
                            echo "existe ".sizeof($regimes)."<br>";
                        //$regimes[0][$regime->getIdRegime()]->getNomAliment()->add($aliment);
                        } else if(array_key_exists($regime->getIdRegime(), $regimes[0])==false) {
                            echo "non ".sizeof($regimes)."<br>";
                            $regime->getNomAliment()->add($aliment);
                            $reg = new Regime();
                            $reg->setIdRegime($regime->getIdRegime());
                            $reg->getNomAliment()->add($aliment);
                            $reg = array($regime->getIdRegime() => $reg);
                            array_push($regimes,$reg);
                        }
                    }
                    else
                    {
                        $regime->getNomAliment()->add($aliment);
                        $reg = new Regime();
                        $reg->setIdRegime($regime->getIdRegime());
                        $reg->getNomAliment()->add($aliment);
                        $reg = array($regime->getIdRegime() => $reg);
                        array_push($regimes,$reg);
                    }*/
                }


            }


        }
        return $this->render('HealthAdvisorBundle:Default/Biennetre_front:listeRegime.html.twig');
    }



}