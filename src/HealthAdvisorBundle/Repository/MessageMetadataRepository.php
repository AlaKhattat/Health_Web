<?php
/**
 * Created by PhpStorm.
 * User: khattout
 * Date: 02/04/2018
 * Time: 16:02
 */

namespace HealthAdvisorBundle\Repository;


class MessageMetadataRepository  extends \Doctrine\ORM\EntityRepository
{
    public function messageNonLus($id)
    {
        $q=$this->getEntityManager()->createQuery("select m from HealthAdvisorBundle:MessageMetadata m WHERE m.isRead=FALSE AND m.participant='$id'");
        return $q->getResult();

    }
}