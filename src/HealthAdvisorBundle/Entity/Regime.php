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

}

