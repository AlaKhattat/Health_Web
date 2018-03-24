<?php

namespace HealthAdvisorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class Admin_TemplateController extends Controller
{
    public function indexAction()
    {
        return $this->render('HealthAdvisorBundle:Admin_Template:index.html.twig', array(
            // ...
        ));
    }

    public function afficher_UsersAction()
    {
        $reposit=$this->getDoctrine()->getRepository("HealthAdvisorBundle:Utilisateur");
        $list=$reposit->findAll();
        return $this->render('@HealthAdvisor/Admin_Template/users_profile.html.twig',array('users'=>$list));
    }
    public function supprimer_UserAction(Request $request)
    {
        $lot=$this->getDoctrine()
            ->getRepository('HealthAdvisorBundle:Utilisateur')
            ->find($request->get('id'));
        $this->getDoctrine()
            ->getManager()
            ->remove($lot);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('admin_users');
    }

}
