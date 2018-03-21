<?php

namespace HealthAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sondage
 *
 * @ORM\Table(name="sondage")
 * @ORM\Entity
 */
class Sondage
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_SONDAGE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSondage;

    /**
     * @var string
     *
     * @ORM\Column(name="NOM_SONDAGE", type="string", length=255, nullable=false)
     */
    private $nomSondage;


}

