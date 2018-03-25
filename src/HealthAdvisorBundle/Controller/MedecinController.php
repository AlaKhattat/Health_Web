<?php

namespace HealthAdvisorBundle\Controller;

use HealthAdvisorBundle\Entity\Medecin;
use HealthAdvisorBundle\Entity\Patient;
use HealthAdvisorBundle\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

/**
 * Medecin controller.
 *
 * @Route("medecin")
 */
class MedecinController extends Controller
{
    /**
     * Lists all medecin entities.
     *
     * @Route("/", name="medecin_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $medecins = $em->getRepository('HealthAdvisorBundle:Medecin')->findAll();

        return $this->render('medecin/index.html.twig', array(
            'medecins' => $medecins,
        ));
    }

    /**
     * Creates a new medecin entity.
     *
     * @Route("/new", name="medecin_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $medecin = new Medecin();
        $patient = new Patient();
        $form = $this->createForm('HealthAdvisorBundle\Form\MedecinType',$medecin);
        $form->handleRequest($request);
        if($request->get('id')!=null) {
            $utilisateur = new Utilisateur();
            $utilisateur = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Utilisateur')->find($request->get('id'));
            if ($form->isSubmitted()) {
                $utilisateur->setRoles(array('ROLES'=>'MEDECIN'));
                $patient->setLogin($utilisateur->getUsername());
                $patient->setPassword($utilisateur->getPassword());
                $patient->setCinUser($utilisateur);
                $medecin->setLogin($patient);
                $medecin->setRating(0);
                $medecin->setStatutCompte('INVALIDE');
                /**
                 * @var UploadedFile $file
                 */
                $file=$medecin->getDiplome();
                $fileName=md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('diplome_url'),$fileName);
                $medecin->setDiplome($fileName);
                $em = $this->getDoctrine()->getManager();
                $em->persist($patient);
                $em->flush();
                $em->persist($utilisateur);
                $em->flush();
                $em->persist($medecin);
                $em->flush();
                $login=$medecin->getLogin();
                return $this->redirectToRoute('medecin_show', array('login' => $login->getLogin()));
            }
        }
        return $this->render('medecin/new.html.twig', array(
            'medecin' => $medecin,
            'form' => $form->createView()
        ));
    }

    /**
     * Finds and displays a medecin entity.
     *
     * @Route("/{login}", name="medecin_show")
     * @Method("GET")
     */
    public function showAction(Medecin $medecin)
    {
        $deleteForm = $this->createDeleteForm($medecin);

        return $this->render('medecin/show.html.twig', array(
            'medecin' => $medecin,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing medecin entity.
     *
     * @Route("/{login}/edit", name="medecin_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Medecin $medecin)
    {
        $deleteForm = $this->createDeleteForm($medecin);
        $editForm = $this->createForm('HealthAdvisorBundle\Form\MedecinType', $medecin);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('medecin_edit', array('login' => $medecin->getLogin()));
        }

        return $this->render('medecin/edit.html.twig', array(
            'medecin' => $medecin,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a medecin entity.
     *
     * @Route("/{login}", name="medecin_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Medecin $medecin)
    {
        $form = $this->createDeleteForm($medecin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($medecin);
            $em->flush();
        }

        return $this->redirectToRoute('medecin_index');
    }

    /**
     * Creates a form to delete a medecin entity.
     *
     * @param Medecin $medecin The medecin entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Medecin $medecin)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('medecin_delete', array('login' => $medecin->getLogin()->getLogin())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
