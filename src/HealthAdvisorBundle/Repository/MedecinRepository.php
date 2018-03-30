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
    public function rechercherParSpecialite($specialite)
    {
        $q=$this->getEntityManager()->createQuery("select m from HealthAdvisorBundle:Medecin m WHERE m.specialite='$specialite'");
        return $q->getResult();
        
    }
    public function rechercherParSpecialiteAdresse($specialite,$adresse)
    {
        $q=$this->getEntityManager()->createQuery("select m from HealthAdvisorBundle:Medecin m WHERE m.specialite='$specialite' AND m.adresse LIKE '%".$adresse."%'" );
        return $q->getResult();

    }

    public function rechercherParAdresse($adresse)
    {
        $q=$this->getEntityManager()->createQuery("select m from HealthAdvisorBundle:Medecin m WHERE  m.adresse LIKE '%".$adresse."%'" );
        return $q->getResult();
    }
    public function rechercherParNom($nom)
    {
        $q=$this->getEntityManager()->createQuery("SELECT medecin FROM HealthAdvisorBundle:Medecin medecin WHERE medecin.login=(SELECT patient.login FROM HealthAdvisorBundle:Patient patient
                                             WHERE patient.cinUser=(SELECT utilisateur.id
                                                                     FROM HealthAdvisorBundle:Utilisateur utilisateur
                                                                     WHERE utilisateur.nom='$nom'))");
        return $q->getResult();
    }
}
