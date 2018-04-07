<?php

namespace HealthAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Query\Expr\Math;
use HealthAdvisorBundle\HealthAdvisorBundle;

/**
 * InformationSante
 *
 * @ORM\Table(name="information_sante")
 * @ORM\Entity
 */
class InformationSante
{
    /**
     * @var float
     *
     * @ORM\Column(name="taille", type="float", precision=10, scale=0, nullable=true)
     */
    private $taille;

    /**
     * @var float
     *
     * @ORM\Column(name="poids", type="float", precision=10, scale=0, nullable=true)
     */
    private $poids;

    /**
     * @var integer
     *
     * @ORM\Column(name="age", type="integer", nullable=true)
     */
    private $age;

    /**
     * @var string
     *
     * @ORM\Column(name="allergies", type="text", length=65535, nullable=true)
     */
    private $allergies;

    /**
     * @var string
     *
     * @ORM\Column(name="maladies", type="text", length=65535, nullable=true)
     */
    private $maladies;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=255, nullable=true)
     */
    private $sexe;

    /**
     * @var HealthAdvisorBundle:Patient
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Patient",cascade={"persist"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="login", referencedColumnName="LOGIN")
     * })
     */
    private $login;

    /**
     * @return float
     */
    public function getTaille()
    {
        return $this->taille;
    }

    /**
     * @param float $taille
     */
    public function setTaille($taille)
    {
        $this->taille = $taille;
    }

    /**
     * @return float
     */
    public function getPoids()
    {
        return $this->poids;
    }

    /**
     * @param float $poids
     */
    public function setPoids($poids)
    {
        $this->poids = $poids;
    }

    /**
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param int $age
     */
    public function setAge($age)
    {
        $this->age = $age;
    }

    /**
     * @return string
     */
    public function getAllergies()
    {
        return $this->allergies;
    }

    /**
     * @param string $allergies
     */
    public function setAllergies($allergies)
    {
        $this->allergies = $allergies;
    }

    /**
     * @return string
     */
    public function getMaladies()
    {
        return $this->maladies;
    }

    /**
     * @param string $maladies
     */
    public function setMaladies($maladies)
    {
        $this->maladies = $maladies;
    }

    /**
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * @param string $sexe
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;
    }

    /**
     * @return HealthAdvisorBundle:Patient
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param HealthAdvisorBundle:Patient $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function explodeAliment($ch)
    {
        return explode(" ",$ch);
    }
    public  function  calculIMC(InformationSante $info)
    {
        //IMC = poids(kg)/(taille*taille)m
         $imc = ($info->getPoids()/(($info->getTaille()*$info->getTaille())/100))*100;

         return round((round($imc *100)/100),2);
    }
    public  function  calculPoidIdeal(InformationSante $info)
    {
        //(homme)=H(taille en cm)−100−((H−150)/4)
        //(femme)=H(taille en cm)−100−((H−150)/2,5
        $poidIdeal = 0;
       if("Homme"==$info->getSexe())
       {
           $poidIdeal = $info->getTaille()-100-(($info->getTaille()-150)/4);
       }
       else if("Femme"==$info->getSexe())
       {
           $poidIdeal = ($info->getTaille())-100-(($info->getTaille()-150)/2.5);
       }

       return $poidIdeal;
    }
    public  function calculCalorieMin(InformationSante $info)
    {
        // femme  MB = 9,74 x P + 172,9 x T - 4,737 x A + 667,051
        //homme adulte MB = 13,707 x P + 492,3 x T - 6,673 x A + 77,607
        $depCalori = 0;
       if("FEMME"==$info->getSexe())
       {
           $depCalori = (9.74 * $info->getPoids)+(172.9*($info->getTaille()/100))-(4.737*$info->getAge())+667.051;
       }
       else if("HOMME"==$info->getSexe())
       {
           $depCalori = (13.707 * $info->getPoids())+(492.3*($info->getTaille()/100))-(6.673*$info->getAge())+77.607;
       }
       return $depCalori;
    }

    public function interpreterIMC($IMC)
    {
        $result ="";
      if($IMC < 16.5)
      {
          $result ="vous etes en etat de Famine suivez un de nos regime";
      }
      else if($IMC >= 16.5 && $IMC < 18.5 )
      {
          $result="vous etes en etat de Maigreur suivez un de nos regime";
      }
      else if($IMC >= 18.5 && $IMC < 25 )
      {
          $result="vous avez une Corpulence normale ";
      }
      else if($IMC >= 25 && $IMC < 30 )
      {
          $result="vous etes en etat de Surpoids suivez un de nos regimes";
      }
      else if($IMC >= 30 && $IMC < 35)
      {
          $result="vous etes en etat d'Obesite moderee suivez un de nos regimes";
      }
      else if($IMC >= 35 && $IMC < 40 )
      {
          $result="vous etes en etat d'Obesite severe suivez un de nos regime";
      }
      else
      {
          $result="vous etes en etat Obesité morbide suivez un de nos regime";
      }

      return $result;
    }

}

