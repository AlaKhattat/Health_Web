<?php

namespace HealthAdvisorBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class Admin_TemplateController extends Controller
{
    public function indexAction()
    {
        return $this->render('HealthAdvisorBundle:Admin_Template:index.html.twig', array(
            // ...
        ));
    }

    public function afficher_UsersAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $reposit=$this->getDoctrine()->getRepository("HealthAdvisorBundle:Utilisateur");
        $list=$reposit->findAll();
        return $this->render('@HealthAdvisor/Admin_Template/users_profile.html.twig',array('users'=>$list,'user'=>$user));
    }
    public function afficher_MedecinAction()
    {

        $em = $this->getDoctrine()->getManager();
        $medecins = $em->getRepository('HealthAdvisorBundle:Medecin')->findAll();
        return $this->render('@HealthAdvisor/Admin_Template/afficher_medecin.html.twig',array('medecins'=>$medecins));
    }


    public function supprimer_UserAction(Request $request)
    {
        $user=$this->getDoctrine()
            ->getRepository('HealthAdvisorBundle:Utilisateur')
            ->find($request->get('id'));
        $this->getDoctrine()
            ->getManager()
            ->remove($user);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('admin_users');
    }

    public function afficher_profile_medecinAction(Request $request)
    {
        $login=$request->get('login');
        $id=$request->get('id');
        $statut=$request->get('statut');
        $em = $this->getDoctrine()->getManager();
        $medecins = $em->getRepository('HealthAdvisorBundle:Medecin')->findOneBy(array('login'=>$login));
        $rdv = $em->getRepository('HealthAdvisorBundle:RendezVous')->findBy(array('med'=>$medecins));
        $rendezvousstat = $em->getRepository('HealthAdvisorBundle:RendezVous')->nbr_rdv_par_mois();

        if ($statut!=null&&$request->get('modifier')=='modifier'){
            return $this->redirectToRoute('admin_modifier_statut_medecin',array('login'=>$id,'statut'=>$statut));
        }
        $serializer = new Serializer(array(new ObjectNormalizer()));
        $resultat= $serializer->normalize($rendezvousstat);

        return $this->render('@HealthAdvisor/Admin_Template/afficher_profile_medecin.html.twig',array('medecin'=>$medecins,'rendezvous'=>$rdv,'stat'=>$resultat,));

    }



    public function modifier_statut_medecinAction(Request $request)
    {
        $statut=$request->get('statut');
        $id=$request->get('login');
        $medecin=$this->getDoctrine()
            ->getRepository('HealthAdvisorBundle:Medecin')
            ->find($id);
            $medecin->setStatutCompte($statut);
            $em = $this->getDoctrine()->getManager();
            $em->persist($medecin);
            $em->flush();

        return $this->redirectToRoute('admin_afficher_profile_medecin',array('login'=>$id));
    }

    public function afficher_list_rendezvousAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $rdv = $em->getRepository('HealthAdvisorBundle:RendezVous')->findAll();
        return $this->render('@HealthAdvisor/Admin_Template/list_rendez_vous.html.twig',array('rendezvous'=>$rdv));
    }

}
