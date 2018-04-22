<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 10/04/2018
 * Time: 09:42
 */

namespace HealthAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RegimeUserSupp
 *
 * @ORM\Table(name="regime_user_supp")
 * @ORM\Entity
 */
class RegimeUserSupp
{
    /**
     * @var string
     *
     * @ORM\Column(name="id_user", type="string", length=255, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idUser;

    /**
     * @var string
     *
     * @ORM\Column(name="id_regime", type="string", length=255, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idRegime;

    /**
     * @var string
     *
     * @ORM\Column(name="id_sport", type="string", length=255, nullable=true)
     */
    private $idSport;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_debut", type="date", nullable=true)
     */
    private $dateDebut;

    /**
     * @var integer
     *
     * @ORM\Column(name="duree", type="integer", nullable=true)
     */
    private $duree;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DailyProgrammeDate", type="date", nullable=true)
     */
    private $dailyprogrammedate;

    /**
     * @var string
     *
     * @ORM\Column(name="DailyAliment", type="text", length=65535, nullable=true)
     */
    private $dailyaliment;



    /**
     * Set idUser
     *
     * @param string $idUser
     *
     * @return RegimeUserSupp
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    
        return $this;
    }

    /**
     * Get idUser
     *
     * @return string
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set idRegime
     *
     * @param string $idRegime
     *
     * @return RegimeUserSupp
     */
    public function setIdRegime($idRegime)
    {
        $this->idRegime = $idRegime;
    
        return $this;
    }

    /**
     * Get idRegime
     *
     * @return string
     */
    public function getIdRegime()
    {
        return $this->idRegime;
    }

    /**
     * Set idSport
     *
     * @param string $idSport
     *
     * @return RegimeUserSupp
     */
    public function setIdSport($idSport)
    {
        $this->idSport = $idSport;
    
        return $this;
    }

    /**
     * Get idSport
     *
     * @return string
     */
    public function getIdSport()
    {
        return $this->idSport;
    }

    /**
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return RegimeUserSupp
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;
    
        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set duree
     *
     * @param integer $duree
     *
     * @return RegimeUserSupp
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;
    
        return $this;
    }

    /**
     * Get duree
     *
     * @return integer
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * Set dailyprogrammedate
     *
     * @param \DateTime $dailyprogrammedate
     *
     * @return RegimeUserSupp
     */
    public function setDailyprogrammedate($dailyprogrammedate)
    {
        $this->dailyprogrammedate = $dailyprogrammedate;
    
        return $this;
    }

    /**
     * Get dailyprogrammedate
     *
     * @return \DateTime
     */
    public function getDailyprogrammedate()
    {
        return $this->dailyprogrammedate;
    }

    /**
     * Set dailyaliment
     *
     * @param string $dailyaliment
     *
     * @return RegimeUserSupp
     */
    public function setDailyaliment($dailyaliment)
    {
        $this->dailyaliment = $dailyaliment;
    
        return $this;
    }

    /**
     * Get dailyaliment
     *
     * @return string
     */
    public function getDailyaliment()
    {
        return $this->dailyaliment;
    }
}
