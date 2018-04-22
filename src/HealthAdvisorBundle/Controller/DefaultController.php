<?php

namespace HealthAdvisorBundle\Controller;
use FOS\UserBundle\Model\UserInterface;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $em = $this->getDoctrine()->getManager();
        $messages = $em->getRepository('HealthAdvisorBundle:MessageMetadata')->messageNonLus($user->getId());
        return $this->render('HealthAdvisorBundle:Default:index.html.twig', array(
            'messages'=>$messages
        ));
    }

    public function afficherNotificationAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $serializer = new Serializer(array(new ObjectNormalizer()));
        $em = $this->getDoctrine()->getManager();
        $notifications = $em->getRepository('HealthAdvisorBundle:Notification')->findBy(array('statut'=>'NonLu','userNotif'=>$user->getId()));
        $resultat= $serializer->normalize($notifications);
        return  new JsonResponse($resultat);

    }
    public function afficherMessageAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $serializer =SerializerBuilder::create()->build();
        $em = $this->getDoctrine()->getManager();
        $messages = $em->getRepository('HealthAdvisorBundle:MessageMetadata')->messageNonLus($user->getId());
        $resultat=$serializer->toArray($messages);
        return  new JsonResponse($resultat);

    }



    public function marquerCommeLusAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        if($request->isXmlHttpRequest())
        {$id=$request->get('id');
            if($id!=null)
            {
                $serializer = new Serializer(array(new ObjectNormalizer()));
                $em = $this->getDoctrine()->getManager();

                $notification = $em->getRepository('HealthAdvisorBundle:Notification')->find($id);
                $notification->setStatut("Lu");
                $em->persist($notification);
                $em->flush();

                $notifications = $em->getRepository('HealthAdvisorBundle:Notification')->findBy(array('statut'=>'NonLu','userNotif'=>$user->getId()));

                $resultat= $serializer->normalize($notifications);
                return  new JsonResponse($resultat);
            }
            }
        return $this->render('HealthAdvisorBundle:Default:index.html.twig');
    }
    public function marquerTousCommeLusAction(Request $request)
    {

        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        if($request->isXmlHttpRequest())
        {
                $serializer = new Serializer(array(new ObjectNormalizer()));
                $em = $this->getDoctrine()->getManager();

                $notifications = $em->getRepository('HealthAdvisorBundle:Notification')->findBy(array('statut'=>'NonLu','userNotif'=>$user->getId()));
                foreach ($notifications as $notification) {
                    $notification->setStatut("Lu");
                    $em->persist($notification);
                    $em->flush();
                }
            $notifications = $em->getRepository('HealthAdvisorBundle:Notification')->findBy(array('statut'=>'NonLu','userNotif'=>$user->getId()));

            $resultat= $serializer->normalize($notifications);
                return  new JsonResponse($resultat);

        }
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

    public function FindMaladieAction()
    {
        $computedHash = base64_encode(hash_hmac ( 'md5' , 'https://authservice.priaid.ch/login' , 'ftHALLrv83JCfdA5', true ));
        $authorization = 'Authorization: Bearer firas_mrad:'.$computedHash;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, '');
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
        curl_setopt($curl, CURLOPT_URL, 'https://authservice.priaid.ch/login');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($curl);
        $obj = json_decode($result);
        //$info = curl_getinfo($curl);
        curl_close($curl);
        return new JsonResponse($obj);
    }

    public function notAllowedAction()
    {
        return $this->render('@HealthAdvisor/Default/notAllowed.html.twig');
    }



}
