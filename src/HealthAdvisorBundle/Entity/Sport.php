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

}

