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

}
