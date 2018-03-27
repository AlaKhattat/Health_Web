<?php

namespace HealthAdvisorBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('HealthAdvisorBundle:Default:index.html.twig');
    }

    public function GeolocalisationAction()
    {
        return $this->render('@HealthAdvisor/Geolocalisation/index.html.twig');
    }

}
