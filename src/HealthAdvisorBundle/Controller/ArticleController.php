<?php

namespace HealthAdvisorBundle\Controller;

use HealthAdvisorBundle\Entity\Medecin;
use HealthAdvisorBundle\Entity\Article;
use HealthAdvisorBundle\Entity\Patient;
use HealthAdvisorBundle\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    public function ajoutArtAction(Request $request)
    {
        $article=new Article();
        $form=$this->createForm(ArticleType::class,$article);
        $form->handleRequest($request);
        $medecin=new Medecin();
        $patient=new Patient();
        $login=$this->container->get('security.token_storage')->getToken()->getUsername();
        var_dump($login);
        $medecin=$this->getDoctrine()->getRepository('HealthAdvisorBundle:Medecin')->find($login);
        var_dump($medecin);
        if($form->isValid()){
            $article->setValidation("Non-définie");
            $article->setIdMedecin($medecin);
            $article->setMoyenneNotes(0);
            $article->setUrlImage("http://localhost/HealthAdvisorImages/".$request->get('img'));
            $em=$this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
            return $this->redirectToRoute('myArt');
        }
        return $this->render('@HealthAdvisor/Article/ajout.html.twig',array('form'=>$form->createView()));
    }



    public function listArtAction()
    {
        $req=$this->getDoctrine()->getRepository('HealthAdvisorBundle:Article');
        $tab=$req->findAll();
        return $this->render('@HealthAdvisor/Article/list.html.twig',array('art'=>$tab));
    }

    public function deleteArtAction($id)
    {
        $article=$this->getDoctrine()->getRepository('HealthAdvisorBundle:Article')->find($id);
        $req=$this->getDoctrine()->getManager();
        $req->remove($article);
        $req->flush();
        $login=$this->container->get('security.token_storage')->getToken()->getUsername();
        $med=$this->getDoctrine()->getRepository('HealthAdvisorBundle:Medecin')->find($login);
        if($article->getIdMedecin()==$med){
            return $this->redirectToRoute('myArt');
        }
        else{
            return $this->redirectToRoute('listArt');
        }
    }

    public function validArtAction($id)
    {
        $article=$this->getDoctrine()->getRepository('HealthAdvisorBundle:Article')->find($id);
        $req=$this->getDoctrine()->getManager();
        $article->setValidation("Validé");
        $req->persist($article);
        $req->flush();
        return $this->redirectToRoute('listArt');
    }

    public function invalidArtAction($id)
    {
        $article=$this->getDoctrine()->getRepository('HealthAdvisorBundle:Article')->find($id);
        $req=$this->getDoctrine()->getManager();
        $article->setValidation("Invalidé");
        $req->persist($article);
        $req->flush();
        return $this->redirectToRoute('listArt');
    }

    public function afficheArtAction($id, Request $request)
    {
        $req=$this->getDoctrine()->getRepository('HealthAdvisorBundle:Article');
        $tab=$req->find($id);
        $article=new Article();
        $article=$tab;
        if($request->get('modif')=="modif"){
            $article->setNom($request->get('nom'));
            $article->setTags($request->get('tags'));
            $article->setContenu($request->get('contenu'));
            $article->setDescription($request->get('description'));
            $article->setUrlImage("http://localhost/HealthAdvisorImages/".$request->get("img"));
            $em=$this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();
        }
        return $this->render('@HealthAdvisor/Article/display.html.twig',array('art'=>$tab));
    }

    public function pdfGenerateAction(Request $request, $id)
    {
        $article=new Article();
        $article=$this->getDoctrine()->getRepository('HealthAdvisorBundle:Article')->find($id);
        var_dump($article);
            $snappy=$this->get("knp_snappy.pdf");
            $html='<h1 style="color: #0000F0" align="center">'.$article->getNom().'</h1></br>'
                .'<img src="'.$article->getUrlImage().'">'
                .'<h3 style="color: #7c1212">'.$article->getDescription().'</h3>'
                .'<h4>'.$article->getTags().'</h4>'
                .'<h5>'.$article->getContenu().'</h5>';
            $filename=$article->getNom();

            return new Response(
                $snappy->getOutputFromHtml($html),
                200,
                array(
                    'Content-Type'          => 'application/pdf',
                    'Content-Disposition'   => 'attachment; filename="'.$filename.'.pdf"'
                )
            );
    }

    public function navigArtAction()
    {
        $req=$this->getDoctrine()->getRepository('HealthAdvisorBundle:Article');
        $tab=$req->findAll();
        return $this->render('@HealthAdvisor/Article/navig.html.twig',array('art'=>$tab));
    }

    public function myArtAction()
    {
        $req=$this->getDoctrine()->getRepository('HealthAdvisorBundle:Article');
        $tab=$req->findAll();
        return $this->render('@HealthAdvisor/Article/myArt.html.twig',array('art'=>$tab));
    }

}