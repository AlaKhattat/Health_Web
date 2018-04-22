<?php

namespace HealthAdvisorBundle\Controller;

use DocDocDoc\NexmoBundle\Message\Simple;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use HealthAdvisorBundle\Entity\Reclamation;

class ReclamationController extends Controller
{
    public function ReclamationAction(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        if(in_array('ROLE_ADMIN', $this->getUser()->getRoles())){
            return $this->render('@HealthAdvisor/Default/notAllowed.html.twig');
        }

        if($request->isXmlHttpRequest()){
            $type=$request->get('type');
            $objet=$request->get('objet');
            $sujet=$request->get('sujet');
            $contenu=$request->get('contenu');
            $user = $this->getUser();
            $etat=false;
            $reclamation=new Reclamation();
            $reclamation->setType($type);
            $reclamation->setObjet($objet);
            $reclamation->setSujet($sujet);
            $reclamation->setContenu($contenu);
            $reclamation->setIdUtilisateur($user);
            $reclamation->setEtat($etat);
            $em = $this->getDoctrine()->getManager();
            $em->persist($reclamation);
            $em->flush();
            $serializer = new Serializer(array(new ObjectNormalizer()));
            $result = $serializer->normalize($reclamation);
            return new JsonResponse($result);
        }
        $medecins=$this->getDoctrine()->getRepository('HealthAdvisorBundle:Medecin')->findAll();
        $produits=$this->getDoctrine()->getRepository('HealthAdvisorBundle:Produit')->findAll();
        $articles=$this->getDoctrine()->getRepository('HealthAdvisorBundle:Article')->findAll();
        $evenements=$this->getDoctrine()->getRepository('HealthAdvisorBundle:Evennement')->findAll();

        return $this->render('@HealthAdvisor/Reclamation/index.html.twig',array(
            'medecins'=>$medecins,
            'produits'=>$produits,
            'articles'=>$articles,
            'evenements'=>$evenements
        ));


    }

    public function reclamationBackAction()
    {
        $reclamations=$this->getDoctrine()->getRepository('HealthAdvisorBundle:Reclamation')->findBy(array('etat'=>false));
        return $this->render('@HealthAdvisor/Admin_Template/reclamation_back/index.html.twig',array(
            'reclamations'=>$reclamations
        ));
    }

    public function ResoudreAction(Request $request)
    {
        $id=$request->get('id');
        $reclamation=$this->getDoctrine()->getRepository('HealthAdvisorBundle:Reclamation')->find($id);
        $reclamation->setEtat(true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($reclamation);
        $em->flush();


        // SMS 1
        $sms = new Simple("HealthAdvisor", "+21623283002", "Réclamation Résolue , Consulter votre boite email [Team HealthAdvisor]");
         $nexmoResponse = $this->container->get('doc_doc_doc_nexmo.send_sms')->send($sms);

        // SMS 2
          $twilio = $this->get('twilio.api');

        $sms2 = $twilio->account->messages->sendMessage(
              '+18132134954', // From a Twilio number in your account
              '+216'.$request->get('phone'), // Text any number
              "Réclamation Résolue , Consulter votre boite email [Team HealthAdvisor]"
          );

        // EMAIL
        $message = (new \Swift_Message('Réclamation résolue'))
            ->setFrom('healthadvisoresprit@gmail.com')
            ->setTo(''.$request->get('email'))
            ->setBody(
                $this->renderView(
                // app/Resources/views/Emails/registration.html.twig
                    '@HealthAdvisor/Admin_Template/reclamation_back/email.html.twig',
                    array('name' => $request->get('nom').'  '.$request->get('prenom'),'type'=>$request->get('type'),'objet'=>$request->get('objet'))
                ),
                'text/html'
            );

        $this->get('mailer')->send($message);


        return $this->redirectToRoute('ReclamationBack');
    }
}
