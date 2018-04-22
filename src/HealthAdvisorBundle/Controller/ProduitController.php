<?php

namespace HealthAdvisorBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use HealthAdvisorBundle\Entity\Orders;
use HealthAdvisorBundle\Entity\Produit;
use HealthAdvisorBundle\Entity\Utilisateur;
use HealthAdvisorBundle\HealthAdvisorBundle;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Session\Session;




class ProduitController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('HealthAdvisorBundle:Produit')->findAll();

        return $this->render('produit/index.html.twig', array(
            'produits' => $produits,
        ));
    }


    public function showAction(Request $request)
    {
        $r=$request->get('id');
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('HealthAdvisorBundle:Produit')->find($r);
        return $this->render('produit/DetailsProduit.html.twig', array(
            'produit' => $produit,
        ));
    }


    public function produitAction()
    {
        $panier=$this->get('session')->get('panier');
        $produits=array();
        $quantite=array();
        $prix_total=0;
        $prix_total_sp=0;
        if(count($panier) != 0) {
            foreach ($panier as $i) {
                $key = array_keys($panier);
                for ($i = 0; $i < count($key); $i++) {
                    $id_produit = $key[$i];
                    $em = $this->getDoctrine()->getManager();
                    $produit = $em->getRepository('HealthAdvisorBundle:Produit')->find($id_produit);
                    $prix_produit_panier=$produit->getPrixVente()*$panier[$key[$i]];
                    $prix_total=$prix_total+($prix_produit_panier-(($prix_produit_panier*$produit->getPromotion())/100));
                    $prix_total_sp=$prix_total_sp+$prix_produit_panier;
                    $produits[$i] = $produit;
                    $quantite[$i] = $panier[$key[$i]];
                }
            }
        }


        return $this->render('produit/Panier.html.twig',array(
            'produits'=>$produits,
            'quantite'=>$quantite,
            'nb_produits'=>count($produits),
            'prix_total' => $prix_total,
            'prix_total_sp'=>$prix_total_sp,
        ));
    }


    public function AddProductPanierAction(Request $request)
    {
        if($this->get('session')->isStarted()==false)
        {
            $this->get('session')->start();
            $this->get('session')->set('panier',array());
        }
        if ($request->isXmlHttpRequest()) {

            $id_produit = $request->get('id_produit');
            //l id
            $user=$this->getUser();
            if (!is_object($user) || !$user instanceof UserInterface) {
                throw new AccessDeniedException('This user does not have access to this section.');
            }
            $pan = $this->get('session')->get('panier');
            //var_dump(count($pan));
            $i=count($pan);
            if($i==0){
                $pan=array($id_produit=>1);
                $this->get('session')->set('panier',$pan);
            }
            else {
                if (array_key_exists($id_produit,$pan) ==true) {
                    $val = $pan[$id_produit];
                    $pan[$id_produit] = $val + 1;
                    $this->get('session')->set('panier',$pan);
                } else {
                    $pan[$id_produit]=1;
                    $this->get('session')->set('panier',$pan);
                }
            }
            $serlizer = new Serializer(array(new ObjectNormalizer()));
            $resultat = $serlizer->normalize($pan);
            return new JsonResponse($resultat);
        }
        return $this->render('produit/index.html.twig');
    }


    Public function SupprimerProduit_PanierAction(Request $request){

        $id_produit=$request->get('id');
        $panier=$this->get('session')->get('panier');
        unset($panier[$id_produit]);
        $this->get('session')->set('panier',$panier);
        $produits=array();
        $quantite=array();
        $prix_total=0;
        $prix_total_sp=0;
        if(count($panier) != 0) {
            foreach ($panier as $i) {
                $key = array_keys($panier);
                for ($i = 0; $i < count($key); $i++) {
                    $id_produit = $key[$i];
                    $em = $this->getDoctrine()->getManager();
                    $produit = $em->getRepository('HealthAdvisorBundle:Produit')->find($id_produit);
                    $prix_produit_panier=$produit->getPrixVente()*$panier[$key[$i]];
                    $prix_total=$prix_total+$prix_produit_panier-(($prix_produit_panier*$produit->getPromotion())/100);
                    $prix_total_sp=$prix_total_sp+$prix_produit_panier;
                    $produits[$i] = $produit;
                    $quantite[$i] = $panier[$key[$i]];
                }
            }
        }

        return $this->render('produit/Panier.html.twig',array(
            'produits'=>$produits,
            'quantite'=>$quantite,
            'nb_produits'=>count($produits),
            'prix_total' => $prix_total,
            'prix_total_sp'=>$prix_total_sp,
        ));

    }


    public  function  UpdatePanierAction(Request $request)
    {
        $prix_total=0;
        $prix_total_sp=0;
        if ($request->isXmlHttpRequest()) {
            $panier=$this->get('session')->get('panier');
            $id_produit = $request->get('id_produit');
            $qte = $request->get('quantite');
            $panier[$id_produit]=$qte;
            $this->get('session')->set('panier',$panier);
            $produits = array();
            $quantite = array();
            if (count($panier) != 0) {
                foreach ($panier as $i) {
                    $key = array_keys($panier);
                    for ($i = 0; $i < count($key); $i++) {
                        $id_produit = $key[$i];
                        $em = $this->getDoctrine()->getManager();
                        $produit = $em->getRepository('HealthAdvisorBundle:Produit')->find($id_produit);
                        $prix_produit_panier=$produit->getPrixVente()*$panier[$key[$i]];
                        $prix_total=$prix_total+$prix_produit_panier-(($prix_produit_panier*$produit->getPromotion())/100);
                        $prix_total_sp=$prix_total_sp+$prix_produit_panier;
                        $produits[$i] = $produit;
                        $quantite[$i] = $panier[$key[$i]];
                    }
                }
            }
            return $this->render('produit/Panier.html.twig', array(
                'produits' => $produits,
                'quantite' => $quantite,
                'nb_produits' => count($produits),
                'prix_total' => $prix_total,
                'prix_total_sp'=>$prix_total_sp,
            ));
        }

    }


    public function AjouterProduit_DetailPanierAction(Request $request){

        if ($request->isXmlHttpRequest()) {

            $id_produit = $request->get('id_produit');
            $user=$this->getUser();
            $qte=$request->get('quantite');
            if (!is_object($user) || !$user instanceof UserInterface) {
                throw new AccessDeniedException('This user does not have access to this section.');
            }
            $pan = $this->get('session')->get('panier');
            //var_dump(count($pan));
            $i=count($pan);
            if($i==0){
                $pan=array($id_produit=>$qte);
                $this->get('session')->set('panier',$pan);
            }
            else {
                if (array_key_exists($id_produit,$pan) ==true) {
                    $val = $pan[$id_produit];
                    $pan[$id_produit] = $val + $qte;
                    $this->get('session')->set('panier',$pan);
                } else {
                    $pan[$id_produit]=$qte;
                    $this->get('session')->set('panier',$pan);
                }
            }
            $serlizer = new Serializer(array(new ObjectNormalizer()));
            $resultat = $serlizer->normalize($pan);
            return new JsonResponse($resultat);
            //$this->redirectToRoute('produit_cart');
        }
        return $this->render('produit/DetailsProduit.html.twig');
    }


    public function AfficherProduits_UserAction(){
        $user=$this->getUser();
        $em = $this->getDoctrine()->getManager();
        $produits = $em->getRepository('HealthAdvisorBundle:Produit')->GetAll_User($user->getId());

        return $this->render('produit/AfficherProduits_user.html.twig', array(
            'produits' => $produits,
        ));
    }


    public function Passer_ModifierProduitAction(Request $request){
        $id_produit=$request->get('id_produit');
        $em = $this->getDoctrine()->getManager();
        $produit=$em->getRepository('HealthAdvisorBundle:Produit')->find($id_produit);
        return $this->render('produit/edit.html.twig',array(
            'produit' => $produit,
        ));
    }


    public function SupprimerProduitAction(Request $request){
        $user=$this->getUser();
        $id_produit=$request->get('id_produit');
        $em = $this->getDoctrine()->getManager();
        $produit=$em->getRepository('HealthAdvisorBundle:Produit')->find($id_produit);
        $em->remove($produit);
        $em->flush();
        $produits=$em->getRepository('HealthAdvisorBundle:Produit')->GetAll_User($user->getId());
        return $this->render('produit/AfficherProduits_user.html.twig',array(
            'produits' => $produits,
        ));
    }

    public  function  ModifierProduitAction(Request $request){
        $id_produit=$request->get('id_produit');
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('HealthAdvisorBundle:Produit')->find($id_produit);
        $user=$this->getUser();
        $produits = $em->getRepository('HealthAdvisorBundle:Produit')->GetAll_User($user->getId());
        if ($request->isXmlHttpRequest()) {
            $ref = $request->get('ref');
            $produit->setReference($ref);
            $nom = $request->get('nom');
            $produit->setNom($nom);
            $desc = $request->get('desc');
            $produit->setDescription($desc);

            $img = $request->get('img');
            if($img!=null) {
                $tab = explode('//', $img);
                $str = $tab[count($tab) - 1];
                $produit->setUrlImage($img);
            }
            $type = $request->get('type');
            $produit->setType($type);
            $prix = $request->get('prix');
            $produit->setPrixVente($prix);
            $promotion = $request->get('promotion');
            $produit->setPromotion($promotion);
            $qte=$request->get('qte');
            $produit->setQuantite($qte);
            $em->persist($produit);
            $em->flush();
            $this->redirectToRoute('afficher_produits_user');
        }
        return $this->render('produit/AfficherProduits_user.html.twig',array(
            'produits'=>$produits
        ));
    }


    public function SortAction(Request $request){

        $choix=$request->get('choix');
        $produits = $this->getDoctrine()->getRepository("HealthAdvisorBundle:Produit")->findAll();
        if ($request->isXmlHttpRequest()) {
            if ($choix == 'A-Z') {
                $produits = $this->getDoctrine()->getRepository("HealthAdvisorBundle:Produit")->SortByNameA_Z();
                $serlizer = new Serializer(array(new ObjectNormalizer()));
                $resultat = $serlizer->normalize($produits);
                return new JsonResponse($resultat);
            }
            elseif ($choix == 'Z-A'){

            }
            elseif ($choix == 'Price: Low to High'){

            }
            elseif ($choix == 'Price: High to Low'){

            }
        }
        return $this->render('produit/index.html.twig',array(
            'produits'=>$produits,
        ));
    }


    public function SignalerProduitAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $id_produit=$request->get('id_produit');
        $btn_value=$request->get('btn_value');
        $produit=$this->getDoctrine()->getRepository('HealthAdvisorBundle:Produit')->find($id_produit);
        $produits = $this->getDoctrine()->getRepository("HealthAdvisorBundle:Produit")->findAll();
        if ($request->isXmlHttpRequest()) {
            if($btn_value == 'Signaler'){
                $produit->setSignalisationEtat(1);
                $em->persist($produit);
                $em->flush();
            }
            else if ($btn_value == 'Annuler') {
                $produit->setSignalisationEtat(0);
                $em->persist($produit);
                $em->flush();
            }
        }
        return $this->render('produit/index.html.twig',array(
            'produits'=>$produits,
        ));
    }


    /*
        public function pdfGenerateAction(Request $request, $id)
        {
            $article=new Article();
            $article=$this->getDoctrine()->getRepository('HealthAdvisorBundle:Article')->find($id);
            $snappy=$this->get("knp_snappy.pdf");
            $html='<h1 style="color: #0000F0" align="center">'.$article->getNom().'</h1></br>'
                .'<img src="'.$article->getUrlImage().'">'
                .'<h3 style="color: #7c1212">'.$article->getDescription().'</h3>'
                .'<h4>'.$article->getTags().'</h4>'
                .'<h5>'.$article->getContenu().'</h5>';
            $filename=$article->getNom();

            return new Response(
                $snappy->getOutputFromHtml($html),
                200,
                array(
                    'Content-Type'          => 'application/pdf',
                    'Content-Disposition'   => 'attachment; filename="'.$filename.'.pdf"'
                )
            );
        }*/

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



    public function AddProduitAction(Request $request){
        $produit=new Produit();
        $user=$this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        if ($request->isXmlHttpRequest()) {
            $ref = $request->get('ref');
            $produit->setReference($ref);
            $nom = $request->get('nom');
            $produit->setNom($nom);
            $desc = $request->get('desc');
            $produit->setDescription($desc);

            $img = $request->get('img');
            $tab = explode('\\',$img);
            $str=$tab[count($tab)-1];
           /* $server_path="C:\\wamp64\\www\HealthAdvisorImages\\".$str;
              copy("C:\\Users\\HABOUB\Desktop\\"+$img,$server_path);
            //$copied = copy($img , $server_path);*/
            $produit->setUrlImage("http://localhost/HealthAdvisorImages/".$str);

            $type = $request->get('type');
            $produit->setType($type);
            $prix = $request->get('prix');
            $produit->setPrixVente($prix);
            $promotion = $request->get('promotion');
            $produit->setPromotion($promotion);
            $qte=$request->get('qte');
            $produit->setQuantite($qte);
            $produit->setIdUser($user->getId());
            $produit->setSignalisationEtat(0);
            $produit->setDateMise(date_create_from_format('Y-m-d',date('Y-m-d')));
            $em = $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();
        }


        return $this->render('produit/new.html.twig');
    }





}
