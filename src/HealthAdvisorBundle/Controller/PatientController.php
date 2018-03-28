<?php

namespace HealthAdvisorBundle\Controller;

use HealthAdvisorBundle\Entity\Patient;
use HealthAdvisorBundle\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Patient controller.
 *
 * @Route("/")
 */
class PatientController extends Controller
{
    /**
     * Lists all patient entities.
     *
     * @Route("/", name="_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $patients = $em->getRepository('HealthAdvisorBundle:Patient')->findAll();

        return $this->render('patient/index.html.twig', array(
            'patients' => $patients,
        ));
    }

    /**
     * Creates a new patient entity.
     *
     * @Route("/new", name="_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $patient = new Patient();
        $form = $this->createForm('HealthAdvisorBundle\Form\PatientType', $patient);
        $form->handleRequest($request);
        if($request->get('id')!=null) {
            $utilisateur = new Utilisateur();

            $utilisateur = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Utilisateur')->find($request->get('id'));

            if ($form->isSubmitted() && $form->isValid()) {
                $utilisateur->setRoles(array('ROLES'=>'PATIENT'));

                $patient->setLogin($utilisateur->getUsername());
                $patient->setPassword($utilisateur->getPassword());
                $patient->setCinUser($utilisateur);
                $em = $this->getDoctrine()->getManager();
                $em->persist($patient);
                $em->flush();
                $this->getDoctrine()->getManager()->persist($utilisateur);
                return $this->redirectToRoute('_show', array('login' => $patient->getLogin()));
            }
        }
        return $this->render('patient/new.html.twig', array(
            'patient' => $patient,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a patient entity.
     *
     * @Route("/{login}", name="_show")
     * @Method("GET")
     */
    public function showAction(Patient $patient)
    {
        $deleteForm = $this->createDeleteForm($patient);

        return $this->render('patient/show.html.twig', array(
            'patient' => $patient,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing patient entity.
     *
     * @Route("/{login}/edit", name="_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Patient $patient)
    {
        $deleteForm = $this->createDeleteForm($patient);
        $editForm = $this->createForm('HealthAdvisorBundle\Form\PatientType', $patient);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('_edit', array('login' => $patient->getLogin()));
        }

        return $this->render('patient/edit.html.twig', array(
            'patient' => $patient,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a patient entity.
     *
     * @Route("/{login}", name="_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Patient $patient)
    {
        $form = $this->createDeleteForm($patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($patient);
            $em->flush();
        }

        return $this->redirectToRoute('_index');
    }

    /**
     * Creates a form to delete a patient entity.
     *
     * @param Patient $patient The patient entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Patient $patient)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('_delete', array('login' => $patient->getLogin())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function afficherRDVAction(Request $request)
    {

    }
}
