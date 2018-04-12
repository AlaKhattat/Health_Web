<?php

namespace HealthAdvisorBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use HealthAdvisorBundle\Entity\Medecin;
use HealthAdvisorBundle\Entity\Notification;
use HealthAdvisorBundle\Entity\Patient;
use HealthAdvisorBundle\Entity\RendezVous;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Rendezvous controller.
 * @Route("rendezvous")
 */
class RendezVousController extends Controller
{
    /**
     * Lists all rendezVous entities.
     *
     * @Route("/", name="rendezvous_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $rendezVouses = $em->getRepository('HealthAdvisorBundle:RendezVous')->findAll();

        return $this->render('rendezvous/index.html.twig', array(
            'rendezVouses' => $rendezVouses,
        ));
    }

    /**
     * Displays a form to edit an existing rendezVous entity.
     *
     * @Route("/new", name="rendezvous_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $login=$request->get('login');

        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $utilisateur=$this->getDoctrine()
            ->getRepository('HealthAdvisorBundle:Utilisateur')
            ->find($user->getId());

        $patient=$this->getDoctrine()
            ->getRepository('HealthAdvisorBundle:Patient')
            ->findOneBy(array('cinUser'=>$utilisateur->getId()));

        $medecin=$this->getDoctrine()
            ->getRepository('HealthAdvisorBundle:Medecin')
            ->find($login);

        $rdv=$this->getDoctrine()
            ->getRepository('HealthAdvisorBundle:RendezVous')
            ->findBy(array('user'=>$patient,'med'=>$medecin));

        $rendezVous = new Rendezvous();
        $form = $this->createForm('HealthAdvisorBundle\Form\RendezVousType', $rendezVous);
        $form->handleRequest($request);

        if ($request->get('rdv')=='rdv') {
            $date=new \DateTime($request->get('date'));
            $rendezVous->setDateHeure($date);
            $rendezVous->setDateValid(new \DateTime());
            $rendezVous->setStatut('ENCOURS');
            $rendezVous->setUser($patient);
            $rendezVous->setMed($medecin);
            $em = $this->getDoctrine()->getManager();
            $em->persist($rendezVous);
            $em->flush();

            return $this->redirectToRoute('rendezvous_new', array(
                'login' => $login,
            ));
        }

        return $this->render('rendezvous/new.html.twig', array(
            'rendezVous' => $rendezVous,
            'user' => $utilisateur,
            'login' => $login,
            'rdv'=>$rdv,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a rendezVous entity.
     *
     * @Route("/{id}", name="rendezvous_show")
     * @Method("GET")
     */
    public function showAction(RendezVous $rendezVous)
    {
        $deleteForm = $this->createDeleteForm($rendezVous);

        return $this->render('rendezvous/show.html.twig', array(
            'rendezVous' => $rendezVous,
            'delete_form' => $deleteForm->createView(),
        ));
    }


    /**
     * Deletes a rendezVous entity.
     *
     * @Route("/{id}", name="rendezvous_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, RendezVous $rendezVous)
    {
        $form = $this->createDeleteForm($rendezVous);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($rendezVous);
            $em->flush();
        }

        return $this->redirectToRoute('rendezvous_index');
    }

    /**
     * Creates a form to delete a rendezVous entity.
     *
     * @param RendezVous $rendezVous The rendezVous entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(RendezVous $rendezVous)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('rendezvous_delete', array('id' => $rendezVous->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
