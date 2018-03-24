<?php

namespace HealthAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use HealthAdvisorBundle\HealthAdvisorBundle;

/**
 * Medecin
 *
 * @ORM\Table(name="medecin")
 * @ORM\Entity
 */
class Medecin
{
    /**
     * @var string
     *
     * @ORM\Column(name="SPECIALITE", type="string", length=255, nullable=false)
     */
    private $specialite;

    /**
     * @var string
     *
     * @ORM\Column(name="ADRESSE", type="string", length=255, nullable=false)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="DIPLOME", type="string", length=255, nullable=false)
     */
    private $diplome;

    /**
     * @var integer
     *
     * @ORM\Column(name="RATING", type="integer", nullable=false)
     */
    private $rating;

    /**
     * @var float
     *
     * @ORM\Column(name="LAT_P", type="float", precision=10, scale=0, nullable=true)
     */
    private $latP;

    /**
     * @var float
     *
     * @ORM\Column(name="LONG_P", type="float", precision=10, scale=0, nullable=true)
     */
    private $longP;

    /**
     * @var string
     *
     * @ORM\Column(name="statut_compte", type="string", length=255, nullable=false)
     */
    private $statutCompte;

    /**
     * @var HealthAdvisorBundle:Patient
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Patient")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="LOGIN", referencedColumnName="LOGIN")
     * })
     */
    private $login;

    /**
     * @return string
     */
    public function getSpecialite()
    {
        return $this->specialite;
    }

    /**
     * @param string $specialite
     */
    public function setSpecialite($specialite)
    {
        $this->specialite = $specialite;
    }

    /**
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    /**
     * @return string
     */
    public function getDiplome()
    {
        return $this->diplome;
    }

    /**
     * @param string $diplome
     */
    public function setDiplome($diplome)
    {
        $this->diplome = $diplome;
    }

    /**
     * @return int
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param int $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    /**
     * @return float
     */
    public function getLatP()
    {
        return $this->latP;
    }

    /**
     * @param float $latP
     */
    public function setLatP($latP)
    {
        $this->latP = $latP;
    }

    /**
     * @return float
     */
    public function getLongP()
    {
        return $this->longP;
    }

    /**
     * @param float $longP
     */
    public function setLongP($longP)
    {
        $this->longP = $longP;
    }

    /**
     * @return string
     */
    public function getStatutCompte()
    {
        return $this->statutCompte;
    }

    /**
     * @param string $statutCompte
     */
    public function setStatutCompte($statutCompte)
    {
        $this->statutCompte = $statutCompte;
    }

    /**
     * @return \Patient
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param \Patient $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }


}

