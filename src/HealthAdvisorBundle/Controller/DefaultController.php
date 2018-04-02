<?php

namespace HealthAdvisorBundle\Controller;

use HealthAdvisorBundle\Entity\BodyParts;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

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

    public function AnalyseSymptAction()
    {
        return $this->render('HealthAdvisorBundle:Analyse_symptome:index.html.twig');
    }

    public function FindBodyPartsAction()
    {

        $bodyparts = $this->getDoctrine()->getRepository('HealthAdvisorBundle:BodyParts')->findAll();
        $serializer = new Serializer(array(new ObjectNormalizer()));
        $result = $serializer->normalize($bodyparts);
        return new JsonResponse($result);

    }

    public function FindSubBodyPartsAction(Request $request)
    {   $id=0;
        if($request->isXmlHttpRequest()){
           $id =$request->get('idbodypart');
    }
        $subbodyparts = $this->getDoctrine()->getRepository('HealthAdvisorBundle:SubBodyParts')->findBy(array('idBodyPart'=>$id));
        $serializer = new Serializer(array(new ObjectNormalizer()));
        $result = $serializer->normalize($subbodyparts);
        return new JsonResponse($result);
    }
    public function FindSymptomsAction(Request $request)
    {   $id=0;
    $gender='';
        if($request->isXmlHttpRequest()){
           $id =$request->get('idsubbodypart');
           $gender=$request->get('gender');
    }
        $symptoms = $this->getDoctrine()->getRepository('HealthAdvisorBundle:SubBodyPartsSymptome')->findBy(array('idSubBody'=>$id,'gender'=>$gender));
        $serializer = new Serializer(array(new ObjectNormalizer()));
        $result = $serializer->normalize($symptoms);
        return new JsonResponse($result);
    }

}
