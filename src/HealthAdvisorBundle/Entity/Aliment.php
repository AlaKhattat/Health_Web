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
     *
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


    /**
     * @return string
     */
    public function getNomAliment()
    {
        return $this->nomAliment;
    }

    /**
     * @param string $nomAliment
     */
    public function setNomAliment($nomAliment)
    {
        $this->nomAliment = $nomAliment;
    }

    /**
     * @return float
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * @param float $quantite
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
    }

    /**
     * @return float
     */
    public function getValeurEnergetique()
    {
        return $this->valeurEnergetique;
    }

    /**
     * @param float $valeurEnergetique
     */
    public function setValeurEnergetique($valeurEnergetique)
    {
        $this->valeurEnergetique = $valeurEnergetique;
    }

    /**
     * @return string
     */
    public function getTypeAliment()
    {
        return $this->typeAliment;
    }

    /**
     * @param string $typeAliment
     */
    public function setTypeAliment($typeAliment)
    {
        $this->typeAliment = $typeAliment;
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

    public function explodeAliment($typAliment)
    {
        return explode(" ",$typAliment);
    }
    //this function take an array type aliment and return an array aliment name type
    public function totalNomAliment(Array  $aliments)
    {
        $totalNomAliments=array();
        for($i = 0; $i < sizeof($aliments); $i++)
        {
            $totalNomAliments[$i]=$aliments[$i]->getNomAliment();
        }
    }


}

