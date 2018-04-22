<?php

namespace HealthAdvisorBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use FOS\UserBundle\Model\UserInterface;
use HealthAdvisorBundle\Entity\Sondage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    public function AfficherProduitAction(){
        $produits=$this->getDoctrine()->getRepository("HealthAdvisorBundle:Produit")->findAll();
        $commandes=$this->getDoctrine()->getRepository("HealthAdvisorBundle:Commande")->findAll();
        return $this->render('HealthAdvisorBundle:Admin_Template/EcommerceBack:Produits_Admin.html.twig',array(
            'produits'=>$produits,
            'commandes'=>$commandes,
        ));
    }

    public function SupprimerProduitAdminAction(Request $request){
        $produit=$this->getDoctrine()->getRepository('HealthAdvisorBundle:Produit')->find($request->get('id_produit'));
        $this->getDoctrine()->getManager()->remove($produit);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('admin_produits');
    }

    public function chartAction()
    {
        //Pie chart des produits signalés et non signalés
        $produits_sign=$this->getDoctrine()->getRepository("HealthAdvisorBundle:Produit")->findBy(['signalisationEtat' => 1]);
        $produits_non_sign=$this->getDoctrine()->getRepository("HealthAdvisorBundle:Produit")->findBy(['signalisationEtat' => 0]);
        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [['Produit Signalé', 'Produit non signalé'],
                ['Produit Signalé',count($produits_sign)],
                ['Produit non signalé', count($produits_non_sign)],
            ]
        );
        $pieChart->getOptions()->setTitle('My Daily Activities');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);


        return $this->render('HealthAdvisorBundle:Admin_Template:AdminChartsProduit.html.twig', array('piechart' => $pieChart));
    }
    public function afficherListeQuestionAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $em = $this->getDoctrine()->getManager();
        $questions = $em->getRepository('HealthAdvisorBundle:Question')->findAll();

        return $this->render('@HealthAdvisor/Admin_Template/question_admin.html.twig', array(
            'questions' => $questions,
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
        return $this->redirectToRoute('afficher_questions_admin');
    }

    public function afficherListeReponsesAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }



        $em = $this->getDoctrine()->getManager();
        $reponses = $this->getDoctrine()
            ->getRepository(Reponse::class)
            ->findBy(array('idQuestion'=>$request->get('id')));
        $question = $this->getDoctrine()->getRepository(Question::class)->find($request->get('id'));


        return $this->render('@HealthAdvisor/Admin_Template/reponse_admin.html.twig', array(
            'reponses' => $reponses,
            'question'=> $question->getQuestion(),
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
        return $this->redirectToRoute('afficher_reponses_admin',array('id'=>$reponse->getIdQuestion()->getId()));
    }

    public function afficherListeSondagesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $sondages = $em->getRepository('HealthAdvisorBundle:Sondage')->findAll();

        return $this->render('@HealthAdvisor/Admin_Template/sondage_admin.html.twig', array(
            'sondages' => $sondages,
        ));
    }

    public function deleteSondageAction(Request $request)
    {
        $sondage = $this->getDoctrine()
            ->getRepository('HealthAdvisorBundle:Sondage')
            ->find($request->get('idSondage'));
        $em =$this->getDoctrine()->getManager();
        $em->remove($sondage);
        $em->flush();
        return $this->redirectToRoute('afficher_sondages_admin');
    }

    public function ajouterSondageAction(Request $request)
    {
        /*Sondage*/
        $sondage = new Sondage();
        $sondage->setNomSondage($request->get('nomSondage'));


        $em = $this->getDoctrine()->getManager();
        $em->persist($sondage);
        $em->flush();
        return new Response();
    }

    public function formSondageAction()
    {
        return $this->render('@HealthAdvisor/Admin_Template/ajouter_sondage.html.twig');
    }

    public function StatAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $compte1 = $em->getRepository('HealthAdvisorBundle:ReponseSondage')->findNbrReponses($request->get('idSondage'),'1');
        $compte2 = $em->getRepository('HealthAdvisorBundle:ReponseSondage')->findNbrReponses($request->get('idSondage'),'2');
        $compte3 = $em->getRepository('HealthAdvisorBundle:ReponseSondage')->findNbrReponses($request->get('idSondage'),'3');
        $compte4 = $em->getRepository('HealthAdvisorBundle:ReponseSondage')->findNbrReponses($request->get('idSondage'),'4');
        $compte5 = $em->getRepository('HealthAdvisorBundle:ReponseSondage')->findNbrReponses($request->get('idSondage'),'5');
        $nbrTotalReponses = $em->getRepository('HealthAdvisorBundle:ReponseSondage')->findNbrTotalSondage($request->get('idSondage'));



        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [['Reponse', 'Pourcentage'],
                ['☆',       count($compte1)],
                ['☆☆',      count($compte2)],
                ['☆☆☆',     count($compte3)],
                ['☆☆☆☆',   count($compte4)],
                ['☆☆☆☆☆',  count($compte5)]
            ]
        );
        $pieChart->getOptions()->setTitle('Statistiques');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);





        return $this->render('@HealthAdvisor/Admin_Template/stat.html.twig', array(

            'pieChart'=>$pieChart,

        ));
    }

}
