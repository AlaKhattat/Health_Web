<?php

namespace HealthAdvisorBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use HealthAdvisorBundle\Entity\Medecin;
use HealthAdvisorBundle\Entity\Notification;
use HealthAdvisorBundle\Entity\Patient;
use HealthAdvisorBundle\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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
     * Lists all medecin selon specialite.
     *
     * @Route("/medecin_specialite", name="medecin_specialite")
     * @Method({"GET", "POST"})
     */
    public function afficher_specialite(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $medecins = $em->getRepository('HealthAdvisorBundle:Medecin')->findAll();
if ($request->get('adresse')!=null||$request->get('specialite')!=null)
{
    return $this->redirectToRoute('medecin_list',array('adresse'=>$request->get('adresse'),'specialite'=>$request->get('specialite'),'username'=>$request->get('username')));
}
        return $this->render('medecin/recherche_medecin.html.twig', array(
            'medecins' => $medecins,
        ));
    }
    /**
     * Lists all medecin selon specialite.
     *
     * @Route("/medecin_list", name="medecin_list")
     * @Method({"GET", "POST"})
     */
    public function afficher_listAction(Request $request)
    {
       $adresse=$request->get('adresse');
       $specialite=$request->get('specialite');
       $nom=$request->get('username');
if($adresse!=null && ($specialite!=null && $specialite!='Selectioner Votre Spécialite')){
        $medecins = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Medecin')->rechercherParSpecialiteAdresse($specialite,$adresse);
}elseif($specialite!=null && $specialite!='Selectioner Votre Spécialite'){

    $medecins = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Medecin')->rechercherParSpecialite($specialite);

}elseif ($adresse!=null){
    $medecins = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Medecin')->rechercherParAdresse($adresse);
}elseif ($nom!=null && $nom!='Selectioner Votre Medecin '){
    $medecins = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Medecin')->rechercherParNom($nom);

}
return $this->render('medecin/afficher_medecin_specialite.html.twig', array(
            'medecins' => $medecins,
        ));
    }

    /**
     * Lists all medecin selon specialite.
     *
     * @Route("/modifier_statut", name="modifier_statut")
     * @Method({"GET", "POST"})
     */
    public function modifier_statutAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $statut=$request->get('statut');
        $id=$request->get('id');
        $rendezvous=$this->getDoctrine()
            ->getRepository('HealthAdvisorBundle:RendezVous')
            ->find($id);

        if($statut!=null){
            if($statut=='VALIDE'){
                $notification=new Notification();
                $rendezvous->setDateValid(new \DateTime());
                $message = (new \Swift_Message('Health Advisor'))
                    ->setFrom('healthadvisoresprit@gmail.com')
                    ->setTo('alakhattat17@gmail.com')
                    ->setBody(
                        $this->renderView(
                            'medecin/emailrdv.html.twig',array('rdv' => $rendezvous)),
                            'text/html'
                    );
                $this->get('mailer')->send($message);
                $notification->setStatut('NonLu');
                $notification->setDate(new \DateTime());
                $notification->setMessage('Vous avez un rendez vous avec le docteur : '.$rendezvous->getMed()->getLogin()->getCinUser()->getNom().' '
                    .$rendezvous->getMed()->getLogin()->getCinUser()->getNom().' Le : '.$rendezvous->getDateHeure()->format('Y m ,d'));
                $notification->setType('Rendez_Vous Confirmé');
                $notification->setUserNotif($rendezvous->getUser()->getCinUser());
                $em->persist($notification);
                $em->flush();

            }
            $rendezvous->setStatut($statut);
            $em->persist($rendezvous);
            $em->flush();
            return $this->redirectToRoute('suivie_rdv');
        }
        return $this->redirectToRoute('suivie_rdv');
    }

    /**
     * Lists all rdv du medecin.
     *
     * @Route("/suivie_rdv", name="suivie_rdv")
     * @Method({"GET", "POST"})
     */
    public function suivie_rdvAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $utilisateur=$this->getDoctrine()
            ->getRepository('HealthAdvisorBundle:Utilisateur')
            ->find($user->getId());
        $patient=$this->getDoctrine()
            ->getRepository('HealthAdvisorBundle:Patient')
            ->findBy(array('cinUser'=>$utilisateur->getId()));

        $medecin=$this->getDoctrine()
            ->getRepository('HealthAdvisorBundle:Medecin')
            ->findBy(array('login'=>$patient));
        $rendezvous=$this->getDoctrine()
            ->getRepository('HealthAdvisorBundle:RendezVous')
            ->findBy(array('med'=>$medecin));
        if ($request->get('statut')!=null)
        {
            return $this->redirectToRoute('modifier_statut',array('statut'=>$request->get('statut'),'id'=>$request->get('id')));
        }
        return $this->render('medecin/suivie_rdv.html.twig', array(
            'user' => $utilisateur,
            'rendezvous' => $rendezvous,
        ));
    }

    /**
     * Lists all medecin selon specialite.
     *
     * @Route("/medecin_details", name="medecin_details")
     * @Method({"GET", "POST"})
     */
    public function afficher_detailsAction(Request $request)
    {
     $login=$request->get('login');

        $medecin =$this->getDoctrine()
            ->getRepository('HealthAdvisorBundle:Medecin')
            ->findOneBy(array('login'=>$login));

        $patient=$this->getDoctrine()
            ->getRepository('HealthAdvisorBundle:Patient')
            ->findOneBy(array('login'=>$medecin->getLogin()));

        $utilisateur=$this->getDoctrine()
            ->getRepository('HealthAdvisorBundle:Utilisateur')
            ->findOneBy(array('id'=>$patient->getCinUser()));


        return $this->render('medecin/afficher_details.html.twig', array(
            'user' => $utilisateur,
            'medecin' => $medecin,
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
                return $this->redirectToRoute('homepage');
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
     *
     * @Route("/{login}", name="medecin_delete")
     * @Method({"GET", "POST"})
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
