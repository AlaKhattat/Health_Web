<?php

namespace HealthAdvisorBundle\Controller;

use HealthAdvisorBundle\Entity\Evennement;
use HealthAdvisorBundle\Entity\Patient;
use HealthAdvisorBundle\Form\EvennementType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;


class EvennementController extends Controller
{
    public function ajoutEvenementAction(Request $request)
    {
        $evenement=new Evennement();
        $form=$this->createForm(EvennementType::class,$evenement);
        $form->handleRequest($request);
        $login=$this->container->get('security.token_storage')->getToken()->getUsername();
        $auteur=$this->getDoctrine()->getRepository('HealthAdvisorBundle:Patient')->find($login);
        if($form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $evenement->setValidation("Non-défini");
            $evenement->setCreateur($login);
            $evenement->addIdUser($auteur);
            $evenement->setUrlImage("http://localhost/HealthAdvisorImages/".$request->get("img"));
            if($evenement->getDate() instanceof \DateTime){
            }else{
                $tab = explode('/',$evenement->getDate());
                $str=$tab[2]."-".$tab[1]."-".$tab[0];
                $evenement->setDate(date_create_from_format('Y-m-d',$str));
            }
            if($evenement->getHeure() instanceof \DateTime){
            }
            else{
                $str2=$evenement->getHeure();
                $hour=$str2[0].":".$str2[1];
                $final=\DateTime::createFromFormat('H:i',$str2);
                $evenement->setHeure($final);
            }
            $em->persist($evenement);
            $em->flush();
            return $this->redirectToRoute('myEvt');
        }
        return $this->render('@HealthAdvisor/Evenement/ajout.html.twig', array(
            'form'=>$form->createView()
        ));
    }

    public function listEvtAction()
    {
        $req=$this->getDoctrine()->getRepository('HealthAdvisorBundle:Evennement');
        $tab=$req->findAll();
        return $this->render('@HealthAdvisor/Evenement/list.html.twig',array('evt'=>$tab));
    }

    public function deleteEvtAction($id)
    {
        $evenement=$this->getDoctrine()->getRepository('HealthAdvisorBundle:Evennement')->find($id);
        $req=$this->getDoctrine()->getManager();
        $req->remove($evenement);
        $req->flush();
        $login=$this->container->get('security.token_storage')->getToken()->getUsername();
        if($login==$evenement->getCreateur()){
            return $this->redirectToRoute('myEvt');
        }else{
            return $this->redirectToRoute('listEvt');
        }
    }

    public function modifEvtAction(Request $request, $id)
    {
        $evenement=$this->getDoctrine()->getRepository('HealthAdvisorBundle:Evennement')->find($id);
        $form=$this->createForm(EvennementType::class, $evenement);
        $form->handleRequest($request);
        if($form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($evenement);
            $em->flush();
            return $this->redirectToRoute('listEvt');
        }
        return $this->render('@HealthAdvisor/Evenement/ajout.html.twig', array('form'=>$form->createView()));
    }

    public function validEvtAction($id)
    {
        $evenement=$this->getDoctrine()->getRepository('HealthAdvisorBundle:Evennement')->find($id);
        $req=$this->getDoctrine()->getManager();
        $evenement->setValidation("Validé");
        $req->persist($evenement);
        $req->flush();
        return $this->redirectToRoute('listEvt');
    }

    public function invalidEvtAction($id)
    {
        $evenement=$this->getDoctrine()->getRepository('HealthAdvisorBundle:Evennement')->find($id);
        $req=$this->getDoctrine()->getManager();
        $evenement->setValidation("Invalidé");
        $req->persist($evenement);
        $req->flush();
        return $this->redirectToRoute('listEvt');
    }

    public function affichEvtAction($id, Request $request)
    {
        $text="";
        $nbrPart=0;
        $full="";
        $req=$this->getDoctrine()->getRepository('HealthAdvisorBundle:Evennement');
        $tab=$req->find($id);
        $evenement=new Evennement();
        $evenement=$tab;
        $compteur=0;
        $login=$this->container->get('security.token_storage')->getToken()->getUsername();
        $participants=$evenement->getIdUser()->getValues();
        if($participants!=null){
        foreach ($participants as $i){
            $nbrPart++;
            if($i->getLogin()==$login){
                $text="oui";
            }
            else{
                $text="non";
            }
            $compteur++;
        }}else{
            $text="non";
        }
        if($compteur==$evenement->getMaxParticipants()){
            $full="oui";
        }else{
            $full="non";
        }
        if($request->get('modif')=='modif') {
            $dat = explode('/', $request->get('date'));
            if (sizeof($dat) > 1) {
                $str = $dat[2] . "-" . $dat[1] . "-" . $dat[0];
            }
            if (date_create_from_format('Y-m-d', $str) == null) {
                $dat = explode(',', $request->get('date'));
                $str1 = $dat[0];
                $str2 = $dat[1];
                $str1Temp = explode(' ', $str1);
                $str2Temp = explode(' ', $str2);
                $strfinal = $str1Temp[1] . "-" . $str1Temp[0] . "-" . $str2Temp[1];
                $date = \DateTime::createFromFormat('j-M-Y', $strfinal);
            } else {
                $date = date_create_from_format('Y-m-d', $str);
            }
            $hour=explode(':',$request->get('heure'));
            if(sizeof($hour)>1){
                $str2=$hour[0].":".$hour[1];
            }
            $hourfinal=$hour[0].":".$hour[1];
            $final=\DateTime::createFromFormat('H:i',$hourfinal);
            $evenement->setNom($request->get('nom'));
            $evenement->setDate($date);
            $evenement->setHeure($final);
            $evenement->setLocation($request->get('location'));
            $evenement->setType($request->get('type'));
            $evenement->setMaxParticipants($request->get('max'));
            $evenement->setDescription($request->get('description'));
            $em=$this->getDoctrine()->getManager();
            $em->persist($evenement);
            $em->flush();
        }
        return $this->render('@HealthAdvisor/Evenement/affiche.html.twig',array('evt'=>$tab, 'text'=>$text, 'full'=>$full, 'nbrPart'=>$nbrPart));
    }

    public function participeAction(Request $request)
    {
        if($request->isXmlHttpRequest()){
            if($request->get('text')=="ajout"){
                $evenement=$this->getDoctrine()->getRepository('HealthAdvisorBundle:Evennement')->find($request->get('id'));
                $patient=$this->getDoctrine()->getRepository('HealthAdvisorBundle:Patient')->find($request->get('login'));
                $evenement->addIdUser($patient);
                $em=$this->getDoctrine()->getManager();
                $em->persist($evenement);
                $em->flush();
                return $this->redirectToRoute('listEvt');
            }
            else{
                $evenement=$this->getDoctrine()->getRepository('HealthAdvisorBundle:Evennement')->find($request->get('id'));
                $patient=$this->getDoctrine()->getRepository('HealthAdvisorBundle:Patient')->find($request->get('login'));
                $evenement->removeIdUser($patient);
                $em=$this->getDoctrine()->getManager();
                $em->persist($evenement);
                $em->flush();
                return $this->redirectToRoute('listEvt');
            }
        }

    }

    public function navigEvtAction()
    {
        $date=new \DateTime('now');
        $string= $date->format('m/d/Y H:i');
        $dat = explode(' ', $string);
        $finalD= $dat[0];
        $req=$this->getDoctrine()->getRepository('HealthAdvisorBundle:Evennement');
        $tab=$req->findAll();
        $events=array();
        foreach ($tab as $i){
            if($i->getDate() > $finalD ){
                $events[]=$i;
            }
        }
        return $this->render('@HealthAdvisor/Evenement/navig.html.twig',array('evt'=>$events));
    }

    public function myEvtAction()
    {
        $date=new \DateTime('now');
        $string= $date->format('m/d/Y H:i');
        $dat = explode(' ', $string);
        $finalD= $dat[0];
        $req=$this->getDoctrine()->getRepository('HealthAdvisorBundle:Evennement');
        $tab=$req->findAll();
        $events=array();
        foreach ($tab as $i){
            if($i->getDate() > $finalD ){
                $events[]=$i;
            }
        }
        return $this->render('@HealthAdvisor/Evenement/myEvt.html.twig',array('evt'=>$events));
    }

    public function rechAjaxAction(Request $request)
    {
        /*$event=$this->getDoctrine()->getRepository('HealthAdvisorBundle:Evennement')->findAll();
        if($request->isXmlHttpRequest()){
            $titre=$request->get('titre');
            $event=$this->getDoctrine()->getRepository('HealthAdvisorBundle:Evennement')->findBy(array('nom'=>$titre));
            $serialiser=new Serializer(array(new ObjectNormalizer()));
            $resultat=$serialiser->normalize($event);
            return new JsonResponse($resultat);
        }
        return $this->render('@HealthAdvisor/Evenement/list.html.twig',array('evt'=>$event));*/
    }

}