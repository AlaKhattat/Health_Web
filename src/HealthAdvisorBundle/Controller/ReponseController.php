<?php

namespace HealthAdvisorBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use HealthAdvisorBundle\Entity\Medecin;
use HealthAdvisorBundle\Entity\Patient;
use HealthAdvisorBundle\Entity\Question;
use HealthAdvisorBundle\Entity\Reponse;
use HealthAdvisorBundle\Entity\ReponsesPossibles;
use HealthAdvisorBundle\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;



/**
 * Reponse controller.
 *
 * @Route("reponse")
 */
class ReponseController extends Controller
{
    /**
     * Lists all reponse entities.
     *
     * @Route("/liste", name="liste_reponse")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {

        $patient = new Patient();
        $medecin = new Medecin();

        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $utilisateur = new Utilisateur();
        $utilisateur = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Utilisateur')->find($user->getId());

        if ($this->get('security.authorization_checker')->isGranted('PATIENT')){
            $patient = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Patient')->findOneBy(array('cinUser'=>$utilisateur->getId()));
        }

        else if ($this->get('security.authorization_checker')->isGranted('MEDECIN')){
            $patient = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Patient')->findOneBy(array('cinUser'=>$utilisateur->getId()));
            $medecin = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Medecin')->findOneBy(array('login'=>$patient->getLogin()));
        }


        $em = $this->getDoctrine()->getManager();
        $reponses = $this->getDoctrine()
            ->getRepository(Reponse::class)
            ->findBy(array('idQuestion'=>$request->get('id')));
        $question = $this->getDoctrine()->getRepository(Question::class)->find($request->get('id'));


        return $this->render('reponse/index.html.twig', array(
            'reponses' => $reponses,
            'question'=> $question->getQuestion(),
            'medecin' => $medecin,
            'patient'=>$patient,
        ));
    }

    /**
     * Creates a new reponse entity.
     *
     * @Route("/ajouter/{id}", name="ajouter_reponse")
     * @Method({"GET", "POST"})
     */
    public function ajouterReponseAction(Request $request, $id)
    {

        $patient = new Patient();
        $medecin = new Medecin();

        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $em = $this->getDoctrine()->getManager();

        $reponse = new Reponse();


        $form = $this->createForm('HealthAdvisorBundle\Form\ReponseType', $reponse);
        $form->handleRequest($request);
        $question = $em->getRepository('HealthAdvisorBundle:Question')->find($request->get('id'));

        if ($form->isSubmitted() && $form->isValid()) {

            $utilisateur = new Utilisateur();
            $utilisateur = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Utilisateur')->find($user->getId());
            $patient = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Patient')->findOneBy(array('cinUser'=>$utilisateur->getId()));
            $medecin = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Medecin')->findOneBy(array('login'=>$patient->getLogin()));
            $reponse->setIdMedecin($medecin);

            $date = new \DateTime();
            $date->modify('+2 hours');
            $reponse->setDatePublication($date);
            $reponse->setModificationEtat(0);
            $reponse->setSignalisationEtat(0);


            $reponse->setIdQuestion($question);


            $em->persist($reponse);
            $em->flush();

/*
            $twilio = $this->get('twilio.api');

            $message = $twilio->account->messages->sendMessage(
                '+15715703576', // From a Twilio number in your account
                '+21658661995', // Text any number
                "Une nouvelle réponse a été ajoutée à votre question!"
            );


            $message = (new \Swift_Message('Réponse sur votre question'))
                ->setFrom('healthadvisoresprit@gmail.com')
                ->setTo($reponse->getIdQuestion()->getIdPatient()->getCinUser()->getEmail())
                ->setBody(
                    $this->renderView(':reponse:email.html.twig',array('reponse'=>$reponse)),
                    'text/html'

                );

            $this->get('mailer')->send($message);

*/



            return $this->redirectToRoute('liste_reponse', array('id' => $question->getId()));
        }

        return $this->render('reponse/ajouter.html.twig', array(
            'question'=>$question->getQuestion(),
            'reponse' => $reponse,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a reponse entity.
     *
     * @Route("/{idReponse}", name="afficher_reponse")
     * @Method("GET")
     */
    public function afficherReponseAction(Reponse $reponse)
    {
        $deleteForm = $this->createDeleteForm($reponse);

        return $this->render('reponse/afficher.html.twig', array(
            'reponse' => $reponse,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing reponse entity.
     *
     * @Route("/{idReponse}/modifier", name="modifier_reponse")
     * @Method({"GET", "POST"})
     */
    public function modifierReponseAction(Request $request, Reponse $reponse)
    {
        $deleteForm = $this->createDeleteForm($reponse);
        $editForm = $this->createForm('HealthAdvisorBundle\Form\ReponseType', $reponse);
        $editForm->handleRequest($request);


        $r = new Reponse();
        $dateActuelle = new \DateTime();
        $dateActuelle->modify('+2 hours');
        $result1 = $dateActuelle->format('Y-m-d H:i:s');
        $r= $this->getDoctrine()->getRepository(Reponse::class)->find($request->get('idReponse'));
        $dateQuestion = $r->getDatePublication();
        $result2 = $dateQuestion->format('Y-m-d H:i:s');
        $timeFirst  = strtotime($result2);
        $timeSecond = strtotime($result1);
        $differenceInSeconds = $timeSecond - $timeFirst;



        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('liste_reponse', array('id' => $reponse->getIdQuestion()->getId()));
        }

        return $this->render('reponse/modifier.html.twig', array(
            'reponse' => $reponse,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'difference' => $differenceInSeconds,
        ));
    }


    public function supprimerReponseAction(Request $request)
    {
        $reponse = $this->getDoctrine()
            ->getRepository('HealthAdvisorBundle:Reponse')
            ->find($request->get('idReponse'));
        $em =$this->getDoctrine()->getManager();
        $em->remove($reponse);
        $em->flush();
        return $this->redirectToRoute('liste_reponse',array('id'=>$reponse->getIdQuestion()->getId()));
    }

    /**
     * Creates a form to delete a reponse entity.
     *
     * @param Reponse $reponse The reponse entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Reponse $reponse)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('supprimer_reponse', array('idReponse' => $reponse->getIdreponse())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
