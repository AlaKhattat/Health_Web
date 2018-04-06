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

}
