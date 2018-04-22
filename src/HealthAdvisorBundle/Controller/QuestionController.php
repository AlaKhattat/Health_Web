<?php

namespace HealthAdvisorBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use HealthAdvisorBundle\Entity\Medecin;
use HealthAdvisorBundle\Entity\Patient;
use HealthAdvisorBundle\Entity\Question;
use HealthAdvisorBundle\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;

/**
 * Question controller.
 *
 * @Route("question")
 */
class QuestionController extends Controller
{


    /**
     * Lists all question entities.
     *
     * @Route("/liste", name="liste_question")
     * @Method("GET")
     */
    public function afficherListeQuestionAction(Request $request)
    {
        $medecin = new Medecin();
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $utilisateur = new Utilisateur();
        $utilisateur = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Utilisateur')->find($user->getId());

        $patient = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Patient')->findOneBy(array('cinUser'=>$utilisateur->getId()));
        if ($this->getDoctrine()->getRepository('HealthAdvisorBundle:Medecin')->findOneBy(array('login'=>$patient->getLogin()))!= null)
        $medecin = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Medecin')->findOneBy(array('login'=>$patient->getLogin()));



        $em = $this->getDoctrine()->getManager();
        $questions = $em->getRepository('HealthAdvisorBundle:Question')->findAll();

        return $this->render('question/index.html.twig', array(
            'questions' => $questions,
            'patient'=>$patient,
            'medecin' => $medecin,

        ));
    }
    /**
     * afficher list mes questions.
     *
     * @Route("/afficherquestion", name="afficher_mes_question")
     * @Method("GET")
     */
    public function afficherMesQuestionsAction(Request $request)
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
        $questions = $em->getRepository('HealthAdvisorBundle:Question')->findMesQuestions($user->getUsername());

        return $this->render('question/mes_questions.html.twig', array(
            'questions' => $questions,
            'medecin' => $medecin,
            'patient'=>$patient,
        ));
    }


    /**
     * Creates a new question entity.
     *
     * @Route("/ajouter", name="ajouter_question")
     * @Method({"GET", "POST"})
     */
    public function ajouterQuestionAction(Request $request)
    {

        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $question = new Question();
        $form = $this->createForm('HealthAdvisorBundle\Form\QuestionType', $question);
        $form->handleRequest($request);


        if ($request->isMethod('POST')) {

            $utilisateur = new Utilisateur();
            $utilisateur = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Utilisateur')->find($user->getId());
            $patient = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Patient')->findOneBy(array('cinUser'=>$utilisateur->getId()));
            $question->setIdPatient($patient);

            $date = new \DateTime();
            $date->modify('+2 hours');
            $question->setDatePublication($date);


            $question->setModificationEtat(0);
            $question->setSignalisationEtat(0);
            $question->setQuestion($request->get('question'));
            $question->setSpecialite($request->get('specialite'));



            $em = $this->getDoctrine()->getManager();
            $em->persist($question);
            $em->flush();

            return $this->redirectToRoute('liste_question', array('id' => $question->getId()));
        }

        return $this->render('question/ajouter.html.twig', array(
            'question' => $question,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a question entity.
     *
     * @Route("/{id}", name="afficher_question")
     * @Method("GET")
     */
    public function afficherQuestionAction(Question $question)
    {
        $deleteForm = $this->createDeleteForm($question);

        return $this->render('question/afficher.html.twig', array(
            'question' => $question,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing question entity.
     *
     * @Route("/{id}/modifier", name="modifier_question")
     * @Method({"GET", "POST"})
     */
    public function modifierQuestionAction(Request $request, Question $question)
    {
        $deleteForm = $this->createDeleteForm($question);
        $editForm = $this->createForm('HealthAdvisorBundle\Form\QuestionType', $question);
        $editForm->handleRequest($request);
        $questionText = $this->getDoctrine()->getRepository(Question::class)->find($request->get('id'));

        $q = new Question();
        $dateActuelle = new \DateTime();
        $dateActuelle->modify('+2 hours');
        $result1 = $dateActuelle->format('Y-m-d H:i:s');
        $q= $this->getDoctrine()->getRepository(Question::class)->find($request->get('id'));
        $dateQuestion = $q->getDatePublication();
        $result2 = $dateQuestion->format('Y-m-d H:i:s');
        $timeFirst  = strtotime($result2);
        $timeSecond = strtotime($result1);
        $differenceInSeconds = $timeSecond - $timeFirst;


        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('liste_question', array('id' => $question->getId()));
        }

        return $this->render('question/modifier.html.twig', array(
            'question' => $question,
            'questionText'=>$question->getQuestion(),
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'difference'=>$differenceInSeconds,
        ));
    }


    public function deleteQuestionAction(Request $request)
    {
        $question = $this->getDoctrine()
        ->getRepository('HealthAdvisorBundle:Question')
        ->find($request->get('id'));
        $em =$this->getDoctrine()->getManager();
        $em->remove($question);
        $em->flush();
        return $this->redirectToRoute('liste_question');
    }

    /**
     * Creates a form to delete a question entity.
     *
     * @param Question $question The question entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Question $question)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('question_supprimer', array('id' => $question->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
