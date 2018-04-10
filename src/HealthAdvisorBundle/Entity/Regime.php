<?php

namespace HealthAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Regime
 *
 * @ORM\Table(name="regime")
 * @ORM\Entity
 */
class Regime
{
    /**
     * @var string
     *
     * @ORM\Column(name="ID_REGIME", type="string", length=255, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idRegime;

    /**
     * @var string
     *
     * @ORM\Column(name="TYPE", type="string", length=255, nullable=false)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="DESCRIPTION_REGIME", type="text", length=65535, nullable=false)
     */
    private $descriptionRegime;

    /**
     * @var integer
     *
     * @ORM\Column(name="DUREE", type="integer", nullable=true)
     */
    private $duree;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Aliment", mappedBy="idRegime")
     */
    private $nomAliment;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Sport", inversedBy="idRegime")
     * @ORM\JoinTable(name="regime_sport",
     *   joinColumns={
     *     @ORM\JoinColumn(name="ID_REGIME", referencedColumnName="ID_REGIME")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="NOM_SPORT", referencedColumnName="NOM_SPORT")
     *   }
     * )
     */
    private $nomSport;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Patient", mappedBy="idRegime")
     */
    private $idUser;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->nomAliment = new \Doctrine\Common\Collections\ArrayCollection();
        $this->nomSport = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idUser = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return string
     */
    public function getIdRegime()
    {
        return $this->idRegime;
    }

    /**
     * @param string $idRegime
     */
    public function setIdRegime($idRegime)
    {
        $this->idRegime = $idRegime;
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
     * @return string
     */
    public function getDescriptionRegime()
    {
        return $this->descriptionRegime;
    }

    /**
     * @param string $descriptionRegime
     */
    public function setDescriptionRegime($descriptionRegime)
    {
        $this->descriptionRegime = $descriptionRegime;
    }

    /**
     * @return int
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * @param int $duree
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNomAliment()
    {
        return $this->nomAliment;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $nomAliment
     */
    public function setNomAliment($nomAliment)
    {
        $this->nomAliment = $nomAliment;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNomSport()
    {
        return $this->nomSport;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $nomSport
     */
    public function setNomSport($nomSport)
    {
        $this->nomSport = $nomSport;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }


    /**
     * Add nomAliment
     *
     * @param \HealthAdvisorBundle\Entity\Aliment $nomAliment
     *
     * @return Regime
     */
    public function addNomAliment(\HealthAdvisorBundle\Entity\Aliment $nomAliment)
    {
        $this->nomAliment[] = $nomAliment;
    
        return $this;
    }

    /**
     * Remove nomAliment
     *
     * @param \HealthAdvisorBundle\Entity\Aliment $nomAliment
     */
    public function removeNomAliment(\HealthAdvisorBundle\Entity\Aliment $nomAliment)
    {
        $this->nomAliment->removeElement($nomAliment);
    }

    /**
     * Add nomSport
     *
     * @param \HealthAdvisorBundle\Entity\Sport $nomSport
     *
     * @return Regime
     */
    public function addNomSport(\HealthAdvisorBundle\Entity\Sport $nomSport)
    {
        $this->nomSport[] = $nomSport;
    
        return $this;
    }

    /**
     * Remove nomSport
     *
     * @param \HealthAdvisorBundle\Entity\Sport $nomSport
     */
    public function removeNomSport(\HealthAdvisorBundle\Entity\Sport $nomSport)
    {
        $this->nomSport->removeElement($nomSport);
    }

    /**
     * Add idUser
     *
     * @param \HealthAdvisorBundle\Entity\Patient $idUser
     *
     * @return Regime
     */
    public function addIdUser(\HealthAdvisorBundle\Entity\Patient $idUser)
    {
        $this->idUser[] = $idUser;
    
        return $this;
    }

    /**
     * Remove idUser
     *
     * @param \HealthAdvisorBundle\Entity\Patient $idUser
     */
    public function removeIdUser(\HealthAdvisorBundle\Entity\Patient $idUser)
    {
        $this->idUser->removeElement($idUser);
    }



}
