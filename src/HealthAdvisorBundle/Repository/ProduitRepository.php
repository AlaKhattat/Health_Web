<?php
/**
 * Created by PhpStorm.
 * User: HABOUB
 * Date: 02/04/2018
 * Time: 23:01
 */

namespace HealthAdvisorBundle\Repository;


class ProduitRepository extends \Doctrine\ORM\EntityRepository
{
    public function SortByNameA_Z()
    {
        $query=$this->getEntityManager()
            ->createQuery("select p from HealthAdvisorBundle:Produit p ORDER BY p.nom ASC ");
        return $query->getResult();
    }

    public function SortByNameZ_A()
    {
        $query=$this->getEntityManager()
            ->createQuery("select p from HealthAdvisorBundle:Produit p ORDER BY p.nom DESC ");
        return $query->getResult();
    }

    public function SortByPriceHigh_Low(){
        $query=$this->getEntityManager()
            ->createQuery("select v from HealthAdvisorBundle:Produit p ORDER BY p.prixVente DESC ");
        return $query->getResult();
    }

    public function SortByPriceLow_High(){
        $query=$this->getEntityManager()
            ->createQuery("select v from HealthAdvisorBundle:Produit p ORDER BY p.prixVente ASC ");
        return $query->getResult();
    }


    public function GetAll_User($id_user){
        $query=$this->getEntityManager()
            ->createQuery("select p from HealthAdvisorBundle:Produit p WHERE p.idUser='".$id_user."'");
        return $query->getResult();
    }

    public function ProduitsLesPlus_Vendus(){
        $query=$this->getEntityManager()
            ->createQuery("select p.nom,p.quantite,SUM(cmd.) from HealthAdvisorBundle:Produit p,HealthAdvisorBundle:Commande cmd   ");
        return $query->getResult();
    }

}