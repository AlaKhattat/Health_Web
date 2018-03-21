<?php

namespace HealthAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(name="age", type="integer", nullable=false)
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
     * @var \Patient
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Patient")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="login", referencedColumnName="LOGIN")
     * })
     */
    private $login;


}

