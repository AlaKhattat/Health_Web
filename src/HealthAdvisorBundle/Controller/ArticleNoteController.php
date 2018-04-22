<?php

namespace HealthAdvisorBundle\Controller;

use HealthAdvisorBundle\Entity\ArticleNote;
use HealthAdvisorBundle\Entity\Patient;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ArticleNoteController extends Controller
{
    public function ajoutNoteAction(Request $request)
    {
        $artNote=new ArticleNote();
        $patient=new Patient();
        $artCont=new ArticleController();
        var_dump('ooooooooooo');
        if($request->isXmlHttpRequest()){
            var_dump('dddddd');
            $article=$this->getDoctrine()->getRepository('HealthAdvisorBundle:Article')->find($request->get('id'));
            $patient=$this->getDoctrine()->getRepository('HealthAdvisorBundle:Patient')->find($request->get('login'));
            $artNote2=$this->getDoctrine()->getRepository('HealthAdvisorBundle:ArticleNote')->findOneBy(array('idUser'=>$patient, 'idArticle'=>$article));
            if($artNote2==null){
                $artNote->setVote($request->get('note'));
                $artNote->setIdArticle($article);
                var_dump('dddddd');
                $artNote->setIdUser($patient);
                $em=$this->getDoctrine()->getManager();
                $em->persist($artNote);
                $em->flush();
            }else{
                $artNote2->setVote($request->get('note'));
                $em=$this->getDoctrine()->getManager();
                var_dump('bbbbb');
                $em->persist($artNote2);
                $em->flush();
            }
            $compteur=0;
            $total=0;
            var_dump('aaaaaaaa');
            $artV=$this->getDoctrine()->getRepository('HealthAdvisorBundle:ArticleNote')->findBy(array('idArticle'=>$article));
            var_dump($artV);
            foreach ($artV as $value){
                $compteur++;
                $total=$total+$value->getVote();
            }
            $final=$total/$compteur;
            $article->setMoyenneNotes($final);
            $em=$this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
        }
        return new JsonResponse();
    }
}
