<?php

namespace HealthAdvisorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('HealthAdvisorBundle:Default:index.html.twig');
    }

}
