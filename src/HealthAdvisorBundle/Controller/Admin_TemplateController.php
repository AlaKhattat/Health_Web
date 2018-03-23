<?php

namespace HealthAdvisorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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

}
