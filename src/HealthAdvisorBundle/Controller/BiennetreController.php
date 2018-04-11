<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 23/03/2018
 * Time: 13:12
 */

namespace HealthAdvisorBundle\Controller;


use Doctrine\Common\Collections\ArrayCollection;
use HealthAdvisorBundle\Entity\Aliment;
use HealthAdvisorBundle\Entity\InformationSante;
use HealthAdvisorBundle\Entity\Nutritionix;
use HealthAdvisorBundle\Entity\Patient;
use HealthAdvisorBundle\Entity\ProgrammeRegime;
use HealthAdvisorBundle\Entity\Regime;
use HealthAdvisorBundle\Entity\RegimeUserSupp;
use HealthAdvisorBundle\Entity\Sport;
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
        $p = new Patient();
        $poidIdeal = 0;
        $informationSante = new InformationSante();
        $patient = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Patient')->findOneBy(array('cinUser'=>$this->container->get('security.token_storage')->getToken()->getUser()));
        $informationSante = $this->getDoctrine()->getRepository('HealthAdvisorBundle:InformationSante')->find($patient->getLogin());
        if($informationSante==null)
        {
            return $this->redirectToRoute('afficher_outilBiennetre');
        }
        if(sizeof($patient->getIdRegime()->getValues())==1)
        {
            $regime = new Regime();
            $regime = $patient->getIdRegime()->get(0);
            return $this->redirectToRoute($this->redirectionRegime($regime->getIdRegime()));
        }

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
        $patient = new Patient();
        $patient = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Patient')->findOneBy(array('cinUser'=>$this->container->get('security.token_storage')->getToken()->getUser()));
         if ($request->isXmlHttpRequest() && sizeof($patient->getIdRegime()->getValues())==0) {
             $programmeRegime = new ProgrammeRegime();
             $infoRegime = new Regime();
             $a = new Aliment();
             // $l->getNomAliment()
             $age = $request->get('age');
             $taille = $request->get('taille');
             $poids = $request->get('poids');
             $poidsAPerdre = $request->get('poidsAperdre');
             $allergies = $request->get('allergies');
             $allergiesSupp = $request->get('allergiesSupp');
             $maladiesSupp = $request->get('maladiesSupp');
             $duree = $request->get('duree');
             $aliments = new Aliment();
             $aliments = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Aliment')->findAll();
             $infoRegime = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Regime')->findAll();
             $allergies = Type_Aliment::returnArrayTypeAliment($allergies);
             $aliments = $programmeRegime->trieAlergiesAliment($aliments, $allergies);
             $listSport = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Sport')->findAll();
             $listRegime = $programmeRegime->recupererTabRegime($aliments, $infoRegime);
             if ($request->get('action') == 'suivreRegime') {
                 $informationSante = new InformationSante();
                 $infoRegimeSupp = new RegimeUserSupp();
                 $regime = new Regime();
                 $sports = new Sport();
                 $informationSante = $this->getDoctrine()->getRepository('HealthAdvisorBundle:InformationSante')->find($patient->getLogin());
                 $informationSante->setAge($age);
                 $informationSante->setPoids($poids);
                 $informationSante->setTaille($taille);
                 if ($allergies != null) {
                     $informationSante->setAllergies(implode('|', array_keys($allergies)));
                 }
                 if ($maladiesSupp != null) {
                     $informationSante->setMaladies(implode('|', $maladiesSupp));
                 }

                 $infoRegimeSupp->setIdRegime($request->get('idRegime'));
                 $infoRegimeSupp->setIdUser($patient->getLogin());
                 $this->getDoctrine()->getManager()->persist($informationSante);
                 $this->getDoctrine()->getManager()->flush();
                 $regime = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Regime')->find($request->get('idRegime'));
                 $sports = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Sport')->findAll();
                 $tabSport = array();
                 foreach ($request->get('sport') as $sport) {
                     $s = new Sport();
                     $tabSport[$sport] = $sport;
                 }
                 $infoRegimeSupp->setIdSport(implode("|", $tabSport));
                 $infoRegimeSupp->setDateDebut(new \DateTime());
                 $infoRegimeSupp->setDuree($duree);
                 $patient->getIdRegime()->add($regime);
                 $this->getDoctrine()->getManager()->persist($patient);  //ajout dans la table user_regime
                 $this->getDoctrine()->getManager()->flush();
                 $this->getDoctrine()->getManager()->persist($infoRegimeSupp);
                 $this->getDoctrine()->getManager()->flush();                  //ajout dans la table infoRegimeSupp
                 return $this->render('HealthAdvisorBundle:Default/Biennetre_front:suivreRegime.html.twig');
             }
             return $this->render('HealthAdvisorBundle:Default/Biennetre_front:listeRegime.html.twig',
                 array("regimes" => $listRegime, "sports" => $listSport, 'age' => $age, 'taille' => $taille, 'poids' => $poids,
                     'poidsAPerdre' => $poidsAPerdre, 'allergies' => $allergies, 'allergiesSupp' => $allergiesSupp,
                     'maladiesSupp' => $maladiesSupp, 'duree' => $duree));
         }
         return $this->redirectToRoute('suivreRegime');

    }
    public  function  regimeDissocieAction(Request $request)
    {
        $patient = new Patient();
        $informationSante = new InformationSante();
        $sports = new Sport();
        $programmeRegime = new ProgrammeRegime();
        $aliments = new Aliment();
        $aliments = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Aliment')->findAll();
        $sports = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Sport')->findAll();
        $patient = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Patient')->findOneBy(array('cinUser'=>$this->container->get('security.token_storage')->getToken()->getUser()));
        $informationSante = $this->getDoctrine()->getRepository('HealthAdvisorBundle:InformationSante')->find($patient->getLogin());
        $listAliment = array();
        $prog = new ProgrammeRegime();
        $regime = new Regime();
        $regime = $patient->getIdRegime()->get(0);
        $userRegimeSupp = $this->getDoctrine()->getRepository('HealthAdvisorBundle:RegimeUserSupp')->findOneBy(array('idUser'=>$patient->getLogin(),'idRegime'=>$regime->getIdRegime()));
        if($informationSante->getAllergies()!=null)
        {
            $allergies = explode('|',$informationSante->getAllergies());
            $allergies = Type_Aliment::returnArrayTypeAliment($allergies);
            $listAliment = $prog->trieAlergiesAliment($regime->getNomAliment()->getValues(),$allergies);
            $listAliment = $prog->trieAliment($listAliment);
        }
        else {
            $listAliment = $prog->trieAliment($regime->getNomAliment()->getValues());
        }

        $tab = $programmeRegime->regimeDissocie($listAliment);
        $ch = $programmeRegime->splitDailyAliment($tab);
        $tabSport = $programmeRegime->retournerListeSports(explode('|',$userRegimeSupp->getIdSport()),$sports);
        if($userRegimeSupp->getDailyprogrammedate()==null || $userRegimeSupp->getDailyprogrammedate() < new \DateTime())
        {
            $userRegimeSupp->setDailyprogrammedate(new \DateTime());
            $userRegimeSupp->setDailyaliment($ch);
            $this->getDoctrine()->getManager()->persist($userRegimeSupp);
            $this->getDoctrine()->getManager()->flush();
        }
        else if($userRegimeSupp->getDailyprogrammedate()==new \DateTime())
        {
            $ch = $userRegimeSupp->getDailyaliment();
            $tab = $programmeRegime->retournerListeDailyAliment($ch,$aliments);
        }
        return $this->render('@HealthAdvisor/Default/Biennetre_front/regimeDissocie.html.twig',array('aliments'=>$tab,'sports'=>$tabSport));

    }
    public  function  regimeHyperProteineAction(Request $request)
    {
        $patient = new Patient();
        $informationSante = new InformationSante();
        $sports = new Sport();
        $programmeRegime = new ProgrammeRegime();
        $aliments = new Aliment();
        $aliments = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Aliment')->findAll();
        $sports = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Sport')->findAll();
        $patient = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Patient')->findOneBy(array('cinUser'=>$this->container->get('security.token_storage')->getToken()->getUser()));
        $informationSante = $this->getDoctrine()->getRepository('HealthAdvisorBundle:InformationSante')->find($patient->getLogin());
        $listAliment = array();
        $prog = new ProgrammeRegime();
        $regime = new Regime();
        $regime = $patient->getIdRegime()->get(0);
        $userRegimeSupp = $this->getDoctrine()->getRepository('HealthAdvisorBundle:RegimeUserSupp')->findOneBy(array('idUser'=>$patient->getLogin(),'idRegime'=>$regime->getIdRegime()));
        if($informationSante->getAllergies()!=null)
        {
            $allergies = explode('|',$informationSante->getAllergies());
            $allergies = Type_Aliment::returnArrayTypeAliment($allergies);
            $listAliment = $prog->trieAlergiesAliment($regime->getNomAliment()->getValues(),$allergies);
            $listAliment = $prog->trieAliment($listAliment);
        }
        else {
            $listAliment = $prog->trieAliment($regime->getNomAliment()->getValues());
        }

        $tab = $programmeRegime->regimeHyperProteine($listAliment);
        $ch = $programmeRegime->splitDailyAliment($tab);
        $tabSport = $programmeRegime->retournerListeSports(explode('|',$userRegimeSupp->getIdSport()),$sports);
        if($userRegimeSupp->getDailyprogrammedate()==null || $userRegimeSupp->getDailyprogrammedate() < new \DateTime())
        {
            $userRegimeSupp->setDailyprogrammedate(new \DateTime());
            $userRegimeSupp->setDailyaliment($ch);
            $this->getDoctrine()->getManager()->persist($userRegimeSupp);
            $this->getDoctrine()->getManager()->flush();
        }
        else if($userRegimeSupp->getDailyprogrammedate()==new \DateTime())
        {
            $ch = $userRegimeSupp->getDailyaliment();
            $tab = $programmeRegime->retournerListeDailyAliment($ch,$aliments);
        }
        return $this->render('@HealthAdvisor/Default/Biennetre_front/regimeHyperProteine.html.twig',array('aliments'=>$tab,'sports'=>$tabSport));
    }
    public  function  regimeHypoCaloriqueAction(Request $request)
    {
        $patient = new Patient();
        $informationSante = new InformationSante();
        $sports = new Sport();
        $programmeRegime = new ProgrammeRegime();
        $aliments = new Aliment();
        $aliments = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Aliment')->findAll();
        $sports = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Sport')->findAll();
        $patient = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Patient')->findOneBy(array('cinUser'=>$this->container->get('security.token_storage')->getToken()->getUser()));
        $informationSante = $this->getDoctrine()->getRepository('HealthAdvisorBundle:InformationSante')->find($patient->getLogin());
        $listAliment = array();
        $prog = new ProgrammeRegime();
        $regime = new Regime();
        $regime = $patient->getIdRegime()->get(0);
        $userRegimeSupp = $this->getDoctrine()->getRepository('HealthAdvisorBundle:RegimeUserSupp')->findOneBy(array('idUser'=>$patient->getLogin(),'idRegime'=>$regime->getIdRegime()));
        if($informationSante->getAllergies()!=null)
        {
            $allergies = explode('|',$informationSante->getAllergies());
            $allergies = Type_Aliment::returnArrayTypeAliment($allergies);
            $listAliment = $prog->trieAlergiesAliment($regime->getNomAliment()->getValues(),$allergies);
            $listAliment = $prog->trieAliment($listAliment);
        }
        else {
            $listAliment = $prog->trieAliment($regime->getNomAliment()->getValues());
        }

        $tab = $programmeRegime->regimeHypoCalorique($listAliment);
        $ch = $programmeRegime->splitDailyAliment($tab);
        $tabSport = $programmeRegime->retournerListeSports(explode('|',$userRegimeSupp->getIdSport()),$sports);
        if($userRegimeSupp->getDailyprogrammedate()==null || $userRegimeSupp->getDailyprogrammedate() < new \DateTime())
        {
            $userRegimeSupp->setDailyprogrammedate(new \DateTime());
            $userRegimeSupp->setDailyaliment($ch);
            $this->getDoctrine()->getManager()->persist($userRegimeSupp);
            $this->getDoctrine()->getManager()->flush();
        }
        else if($userRegimeSupp->getDailyprogrammedate()==new \DateTime())
        {
            $ch = $userRegimeSupp->getDailyaliment();
            $tab = $programmeRegime->retournerListeDailyAliment($ch,$aliments);
        }
        return $this->render('@HealthAdvisor/Default/Biennetre_front/regimeHypocalorique.html.twig',array('aliments'=>$tab,'sports'=>$tabSport));

    }
    public  function  regimeJeuneAction(Request $request)
    {
        return $this->render('@HealthAdvisor/Default/Biennetre_front/regimeJeune.html.twig');
    }
    public  function  regimeMicronutritionAction(Request $request)
    {
        $patient = new Patient();
        $informationSante = new InformationSante();
        $sports = new Sport();
        $programmeRegime = new ProgrammeRegime();
        $aliments = new Aliment();
        $aliments = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Aliment')->findAll();
        $sports = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Sport')->findAll();
        $patient = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Patient')->findOneBy(array('cinUser'=>$this->container->get('security.token_storage')->getToken()->getUser()));
        $informationSante = $this->getDoctrine()->getRepository('HealthAdvisorBundle:InformationSante')->find($patient->getLogin());
        $listAliment = array();
        $prog = new ProgrammeRegime();
        $regime = new Regime();
        $regime = $patient->getIdRegime()->get(0);
        $userRegimeSupp = $this->getDoctrine()->getRepository('HealthAdvisorBundle:RegimeUserSupp')->findOneBy(array('idUser'=>$patient->getLogin(),'idRegime'=>$regime->getIdRegime()));
        if($informationSante->getAllergies()!=null)
          {
                $allergies = explode('|',$informationSante->getAllergies());
                $allergies = Type_Aliment::returnArrayTypeAliment($allergies);
                $listAliment = $prog->trieAlergiesAliment($regime->getNomAliment()->getValues(),$allergies);
                $listAliment = $prog->trieAliment($listAliment);
          }
          else {
                $listAliment = $prog->trieAliment($regime->getNomAliment()->getValues());
            }

        $tab = $programmeRegime->regimeMicronutrition($listAliment);
        $ch = $programmeRegime->splitDailyAliment($tab);
        $tabSport = $programmeRegime->retournerListeSports(explode('|',$userRegimeSupp->getIdSport()),$sports);
        if($userRegimeSupp->getDailyprogrammedate()==null || $userRegimeSupp->getDailyprogrammedate() < new \DateTime())
        {
            $userRegimeSupp->setDailyprogrammedate(new \DateTime());
            $userRegimeSupp->setDailyaliment($ch);
            $this->getDoctrine()->getManager()->persist($userRegimeSupp);
            $this->getDoctrine()->getManager()->flush();
        }
        else if($userRegimeSupp->getDailyprogrammedate()==new \DateTime())
        {
            $ch = $userRegimeSupp->getDailyaliment();
            $tab = $programmeRegime->retournerListeDailyAliment($ch,$aliments);
        }
        return $this->render('@HealthAdvisor/Default/Biennetre_front/regimeMicronutrion.html.twig',array('aliments'=>$tab,'sports'=>$tabSport));
    }

    public  function  redirectionRegime($nomRegime)
    {
        $routes = array(
                        "micronutrition"=>"micronutrition",
                        "le jeune"=>'regime_jeune',
                        "regime dissocie"=>'regime_dissocie',
                        "regime hyperproteine"=>'regime_hyper_proteine',
                        "regime hypocalorique"=>'regime_hypo_calorique'
        );
        return $routes[$nomRegime];
    }
   public  function  supprimerRegimeAction($nomRegime)
   {
       $patient = new Patient();
       $informationSante = new InformationSante();
       $patient = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Patient')->findOneBy(array('cinUser'=>$this->container->get('security.token_storage')->getToken()->getUser()));
       $informationSante = $this->getDoctrine()->getRepository('HealthAdvisorBundle:InformationSante')->find($patient->getLogin());
       $userRegimeSupp = $this->getDoctrine()->getRepository('HealthAdvisorBundle:RegimeUserSupp')->findOneBy(array('idUser'=>$patient->getLogin(),'idRegime'=>$nomRegime));
       if($patient->getIdRegime()->get(0)->getIdRegime()==$nomRegime && $informationSante!=null && $userRegimeSupp!=null)
      {
          $co = new ArrayCollection();
          $patient->getIdRegime()->remove($nomRegime);
          $patient->getIdRegime()->clear();
          $this->getDoctrine()->getManager()->persist($patient);
          $this->getDoctrine()->getManager()->flush();
          $this->getDoctrine()->getManager()->remove($informationSante);
          $this->getDoctrine()->getManager()->flush();
          $this->getDoctrine()->getManager()->remove($userRegimeSupp);
          $this->getDoctrine()->getManager()->flush();
          return $this->redirectToRoute("homepage");
      }

   }


}