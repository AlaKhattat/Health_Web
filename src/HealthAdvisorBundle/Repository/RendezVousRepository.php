<?php
/**
 * Created by PhpStorm.
 * User: khattout
 * Date: 11/04/2018
 * Time: 00:39
 */

namespace HealthAdvisorBundle\Repository;


class RendezVousRepository extends \Doctrine\ORM\EntityRepository
{

    public function nbr_rdv_par_mois()
    {
        $q=$this->getEntityManager()->createQuery(" 
        select COUNT(rdv.id) as nombre ,extract(MONTH FROM rdv.dateHeure) as mois FROM HealthAdvisorBundle:RendezVous rdv GROUP BY rdv.dateHeure");
        return $q->getResult();
    }

}