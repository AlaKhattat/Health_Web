<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 09/04/2018
 * Time: 11:37
 */

namespace HealthAdvisorBundle\Repository;


use Doctrine\ORM\EntityRepository;

class QuestionRepository extends EntityRepository
{

    public function findMesQuestions($login)
    {
        $q = $this->getEntityManager()
            ->createQuery("SELECT q FROM HealthAdvisorBundle:Question q
                      WHERE q.idPatient = '$login'");
        return $q->getResult();
    }
    
}