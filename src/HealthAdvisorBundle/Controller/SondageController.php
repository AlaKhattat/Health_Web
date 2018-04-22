<?php

namespace HealthAdvisorBundle\Controller;

use blackknight467\StarRatingBundle\Form\RatingType;
use FOS\UserBundle\Model\UserInterface;
use HealthAdvisorBundle\Entity\Patient;
use HealthAdvisorBundle\Entity\ReponseSondage;
use HealthAdvisorBundle\Entity\Sondage;
use HealthAdvisorBundle\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SondageController extends Controller
{
    public function afficherListeSondagesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $sondages = $em->getRepository('HealthAdvisorBundle:Sondage')->findAll();

        return $this->render(':Sondage:sondage.html.twig', array(
            'sondages' => $sondages,
        ));
    }

    public function avisAction(Request $request)
    {
        return $this->render(":Sondage:avis.html.twig", array('nomSondage' => $request->get('nomSondage'),'idSondage' => $request->get('idSondage')));
    }

    public function AjoutReponseAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $utilisateur = new Utilisateur();
        $utilisateur = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Utilisateur')->find($user->getId());
        $patient = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Patient')->findOneBy(array('cinUser'=>$utilisateur->getId()));




        $sondage = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Sondage')->find($request->get('sondage'));

        $reponseSondage = new ReponseSondage();
        $reponseSondage->setIdUser($patient);
        $reponseSondage->setReponse($request->get('rating'));
        $reponseSondage->setSondage($sondage);

            $em = $this->getDoctrine()->getManager();
            $em->persist($reponseSondage);
            $em->flush();

            return new Response();
    }







}
