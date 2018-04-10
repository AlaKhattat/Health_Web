<?php

namespace HealthAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sport
 *
 * @ORM\Table(name="sport")
 * @ORM\Entity
 */
class Sport
{
    /**
     * @var string
     *
     * @ORM\Column(name="NOM_SPORT", type="string", length=255, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $nomSport;

    /**
     * @var string
     *
     * @ORM\Column(name="TYPE", type="string", length=255, nullable=false)
     */
    private $type;

    /**
     * @var float
     *
     * @ORM\Column(name="DEPENSE_ENERGETIQUE", type="float", precision=10, scale=0, nullable=false)
     */
    private $depenseEnergetique;

    /**
     * @var string
     *
     * @ORM\Column(name="lienSport", type="string", length=255, nullable=true)
     */
    private $liensport;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Regime", mappedBy="nomSport")
     */
    private $idRegime;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idRegime = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return string
     */
    public function getNomSport()
    {
        return $this->nomSport;
    }

    /**
     * @param string $nomSport
     */
    public function setNomSport($nomSport)
    {
        $this->nomSport = $nomSport;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return float
     */
    public function getDepenseEnergetique()
    {
        return $this->depenseEnergetique;
    }

    /**
     * @param float $depenseEnergetique
     */
    public function setDepenseEnergetique($depenseEnergetique)
    {
        $this->depenseEnergetique = $depenseEnergetique;
    }

    /**
     * @return string
     */
    public function getLiensport()
    {
        return $this->liensport;
    }

    /**
     * @param string $liensport
     */
    public function setLiensport($liensport)
    {
        $this->liensport = $liensport;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdRegime()
    {
        return $this->idRegime;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $idRegime
     */
    public function setIdRegime($idRegime)
    {
        $this->idRegime = $idRegime;
    }

}

