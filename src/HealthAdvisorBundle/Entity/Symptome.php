<?php

namespace HealthAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Symptome
 *
 * @ORM\Table(name="symptome")
 * @ORM\Entity
 */
class Symptome
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_SYMPTOME", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSymptome;

    /**
     * @var string
     *
     * @ORM\Column(name="NOM_SYMPTOME", type="string", length=255, nullable=false)
     */
    private $nomSymptome;

    /**
     * @var string
     *
     * @ORM\Column(name="DESCRIPTION", type="string", length=255, nullable=false)
     */
    private $description;


}

