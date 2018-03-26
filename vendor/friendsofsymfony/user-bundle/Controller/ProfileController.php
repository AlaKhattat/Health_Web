<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FOS\UserBundle\Controller;

use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use HealthAdvisorBundle\Entity\Patient;
use HealthAdvisorBundle\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Controller managing the user profile.
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
class ProfileController extends Controller
{
    private $eventDispatcher;
    private $formFactory;
    private $userManager;

    public function __construct(EventDispatcherInterface $eventDispatcher, FactoryInterface $formFactory, UserManagerInterface $userManager)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->formFactory = $formFactory;
        $this->userManager = $userManager;
    }

    /**
     * Show the user.
     */
    public function showAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        if($user->getRoles()[0] =="PATIENT")
        {
            $patient = new Patient();
            $patient = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Patient')->findOneBy(array('cinUser'=>$user));
            $id = $user->getId();
            return $this->showPatientAction($patient,$request);
            //return  $this->redirectToRoute("_show",array('login'=>$patient->getLogin()));
        }
        return $this->render('@FOSUser/Profile/show.html.twig', array(
            'user' => $user,
        ));
    }

    /**
     * Edit the user.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function editAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $event = new GetResponseUserEvent($user, $request);
        $this->eventDispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $this->formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event = new FormEvent($form, $request);
            $this->eventDispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);

            $this->userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $url = $this->generateUrl('fos_user_profile_show');
                $response = new RedirectResponse($url);
            }

            $this->eventDispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

            return $response;
        }

        return $this->render('@FOSUser/Profile/edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function showPatientAction(Patient $patient,Request $request)
    {

        $deleteForm = $this->createDeleteForm($patient);
        $patient2 = new Patient();
        if($request->get('modifier')=="modif" )
        {
            $tab = explode('/',$request->get('dateNaiss'));
            $str="";
            if(sizeof($tab)>1) {
                $str = $tab[2] . "-" . $tab[1] . "-" . $tab[0];
            }
            if(date_create_from_format('Y-m-d',$str)==null) {
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
    public function deletePatientAction(Request $request)
    {
        $patient = new Patient();
        $patient= $this->getDoctrine()->getRepository("HealthAdvisorBundle:Patient")->find($request->get('login'));

        if ($patient !=null) {
            $user = new Utilisateur();
            $user = $this->getDoctrine()->getRepository("HealthAdvisorBundle:Utilisateur")->find($patient->getCinUser()->getId());
            $em = $this->getDoctrine()->getManager();
            $em->remove($patient);
            $em->flush();
        }

        return $this->redirectToRoute('fos_user_security_logout');
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
            ->setAction($this->generateUrl('fos_user_profile_deletePatient'))
            ->setMethod('GET')
            ->getForm()
            ;
    }
}
