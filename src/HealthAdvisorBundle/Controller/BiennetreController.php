<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 23/03/2018
 * Time: 13:12
 */

namespace HealthAdvisorBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BiennetreController extends Controller
{
    public function indexOutilBiennetreAction()
    {
       return  $this->render("HealthAdvisorBundle:Default/Biennetre_front:outilsBiennetre.html.twig");
    }
}