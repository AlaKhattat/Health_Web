<?php

namespace HealthAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BodyParts
 *
 * @ORM\Table(name="body_parts")
 * @ORM\Entity
 */
class BodyParts
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_BODY_PART", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idBodyPart;

    /**
     * @var string
     *
     * @ORM\Column(name="NOM_BODY_PART", type="string", length=255, nullable=false)
     */
    private $nomBodyPart;

    /**
     * @return int
     */
    public function getIdBodyPart()
    {
        return $this->idBodyPart;
    }

    /**
     * @param int $idBodyPart
     */
    public function setIdBodyPart($idBodyPart)
    {
        $this->idBodyPart = $idBodyPart;
    }

    /**
     * @return string
     */
    public function getNomBodyPart()
    {
        return $this->nomBodyPart;
    }

    /**
     * @param string $nomBodyPart
     */
    public function setNomBodyPart($nomBodyPart)
    {
        $this->nomBodyPart = $nomBodyPart;
    }


}

