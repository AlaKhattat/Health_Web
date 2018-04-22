<?php

namespace HealthAdvisorBundle\Controller;

use HealthAdvisorBundle\Entity\Aliment;
use HealthAdvisorBundle\Entity\Type_Aliment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * Aliment controller.
 *
 * @Route("admin/")
 */
class AlimentController extends Controller
{

    public function afficherAlimentAction()
    {
        $em = $this->getDoctrine()->getManager();

        $aliments = $em->getRepository('HealthAdvisorBundle:Aliment')->findAll();

        return $this->render('@HealthAdvisor/Admin_Template/Biennetre_back/afficherAliment.html.twig', array(
            'aliments' => $aliments,
        ));
    }

    public function ajouterAlimentAction(Request $request)
    {
        $aliment = new Aliment();

        $em = $this->getDoctrine()->getManager();
        if ($request->isMethod('GET') && $request->get('typeAliment')!="" && $request->get('action')==null)
        {
            $aliment = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Aliment')->find($request->get('nomAliment'));
            if($aliment ==null)
            {
                $aliment = new Aliment();
            }
            $tab = (array)$request->get('typeAliment');
            $tabTypeAliment  = array();
            foreach ($tab as $item)
            {
                $element = explode(",",$item);
                if(sizeof($element)>1)
                {
                    foreach ($element as $sousChaine)
                    {
                        if($sousChaine!="")
                        {
                            array_push($tabTypeAliment,$sousChaine);
                        }
                    }
                }
                else
                {
                    array_push($tabTypeAliment,$item);
                }
            }
            $aliment->setNomAliment($request->get('nomAliment'));
            $aliment->setQuantite($request->get('quantite'));
            $aliment->setTypeAliment(implode(" ",$tabTypeAliment));
            $aliment->setValeurEnergetique($request->get('valeurEnergetique'));
            $em->persist($aliment);
            $em->flush();
            return $this->redirectToRoute('afficher_aliment');
        }
        else if($request->get('action')=='modifier' && $request->get('nomAliment')!=null)
        {
            $aliment = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Aliment')->find($request->get('nomAliment'));
        }

        return $this->render('@HealthAdvisor/Admin_Template/Biennetre_back/ajouterAliment.html.twig', array(
            "typeAliment"=>Type_Aliment::$type_aliment,"aliment"=>$aliment
        ));
    }


    public function rechercheAlimentAction(Aliment $aliment)
    {
        $deleteForm = $this->createDeleteForm($aliment);

        return $this->render('aliment/show.html.twig', array(
            /*'aliment' => $aliment,
            'delete_form' => $deleteForm->createView(),*/
        ));
    }


    public function modifierAlimentAction(Request $request)
    {

        if ($request->get('nomAliment')!=null)
        {
            $aliment = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Aliment')->find($request->get('nomAliment'));
            return $this->redirectToRoute('ajouter_aliment', array('action'=>'modifier','nomAliment' => $aliment->getNomaliment()));
        }

        return $this->render('@HealthAdvisor/Admin_Template/Biennetre_back/afficherAliment.html.twig', array());
    }


    public function supprimerAlimentAction(Request $request)
    {
        if($request->isXmlHttpRequest()) {
            if ($request->get('nomAliment') != "") {
                $aliment = $this->getDoctrine()->getRepository('HealthAdvisorBundle:Aliment')
                    ->find($request->get('nomAliment'));
                $em = $this->getDoctrine()->getManager();
                $em->remove($aliment);
                $em->flush();
                $em = $this->getDoctrine()->getManager();
                $aliments = $em->getRepository('HealthAdvisorBundle:Aliment')->findAll();
                return  $this->render('@HealthAdvisor/Admin_Template/Biennetre_back/parcourAliment.html.twig',array('aliments'=>$aliments));
            }
        }
        return $this->redirectToRoute('afficher_aliment');
    }

    public function AfficherRegimeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $regimes = $em->getRepository('HealthAdvisorBundle:Regime')->findAll();
        return $this->render('@HealthAdvisor/Admin_Template/Biennetre_back/gestionRegime.html.twig',array("regimes"=>$regimes));
    }

}
