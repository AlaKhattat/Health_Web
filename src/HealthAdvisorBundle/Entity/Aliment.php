<?php

namespace HealthAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Aliment
 *
 * @ORM\Table(name="aliment")
 * @ORM\Entity
 */
class Aliment
{
    /**
     * @var string
     *
     * @ORM\Column(name="NOM_ALIMENT", type="string", length=255, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $nomAliment;

    /**
     * @var float
     *
     * @ORM\Column(name="QUANTITE", type="float", precision=10, scale=0, nullable=false)
     */
    private $quantite;

    /**
     * @var float
     *
     * @ORM\Column(name="VALEUR_ENERGETIQUE", type="float", precision=10, scale=0, nullable=true)
     */
    private $valeurEnergetique;

    /**
     * @var string
     *
     * @ORM\Column(name="TYPE_ALIMENT", type="string", length=255, nullable=false)
     */
    private $typeAliment;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Regime", inversedBy="nomAliment")
     * @ORM\JoinTable(name="aliment_regime",
     *   joinColumns={
     *     @ORM\JoinColumn(name="NOM_ALIMENT", referencedColumnName="NOM_ALIMENT")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ID_REGIME", referencedColumnName="ID_REGIME")
     *   }
     * )
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

