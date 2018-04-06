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
                return $this->redirectToRoute('fos_user_profile_show', array('login' => $patient->getLogin()));
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
  /*  public function showAction(Patient $patient,Request $request)
    {

        $deleteForm = $this->createDeleteForm($patient);
        $patient2 = new Patient();
        echo "dd";
        if($request->get('modifier')=="modif" )
        {
            $tab = explode('/',$request->get('dateNaiss'));
            $str="";
            if(sizeof($tab)>1) {
                $str = $tab[2] . "-" . $tab[1] . "-" . $tab[0];
            }
            if(date_create_from_format('Y-m-d ',$str)==null) {
                $tab = explode(',', $request->get('dateNaiss'));
                $str1 = $tab[0];
                $str2 = $tab[1];
                $str1Temp = explode(' ', $str1);
                $str2Temp = explode(' ', $str2);
                $strfinal = $str1Temp[1] . "-" . $str1Temp[0] . "-" . $str2Temp[1];
                $date = \DateTime::createFromFormat('j-M-Y', $strfinal);
            }
            else{
                $date = date_create_from_format('Y-m-d',$str);
            }
            $patient2 = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Patient')->find($patient->getLogin());
            $patient2->getCinUser()->setNom($request->get('nom'));
            $patient2->getCinUser()->setPrenom($request->get('prenom'));
            $patient2->getCinUser()->setNumTel($request->get('tel'));
            $patient2->getCinUser()->setDateNaiss($date);
            $patient2->getCinUser()->setPays($request->get('pays'));
            $patient2->getCinUser()->setVille($request->get('ville'));
            $patient2->setPhotoProfile($request->get('photo'));
            $em = $this->getDoctrine()->getManager();
            $em->persist($patient2);
            $em->flush();
        }
        $modifForm = $this->createForm('HealthAdvisorBundle\Form\PatientModifType',$patient2);
        return $this->render('patient/show.html.twig', array(
            'patient' => $patient,
            'modif_form'=> $modifForm->createView(),
            'delete_form' => $deleteForm->createView(),

        ));
    }
*/
    /**
     * Displays a form to edit an existing patient entity.
     *
     * @Route("/{login}/edit", name="_edit")
     * @Method({"GET", "POST"})
     */


    /**
     * Deletes a patient entity.
     *
     * @Route("/{login}", name="_delete")
     * @Method("DELETE")
     */

}
