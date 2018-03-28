<?php
/**
 * Created by PhpStorm.
 * User: khattout
 * Date: 26/03/2018
 * Time: 13:18
 */

namespace HealthAdvisorBundle\Repository;


class MedecinRepository  extends \Doctrine\ORM\EntityRepository
{
    public function rechercherParSpécialite($spécialite)
    {
        $q=$this->getEntityManager()->createQuery("select m from HealthAdvisorBundle:Medecin m WHERE m.specialite='.$spécialite.'");
        return $q->getResult();
        
    }
}
