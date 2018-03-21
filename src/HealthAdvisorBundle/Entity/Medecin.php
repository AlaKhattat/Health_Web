<?php

namespace HealthAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var \Patient
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Patient")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="LOGIN", referencedColumnName="LOGIN")
     * })
     */
    private $login;


}

