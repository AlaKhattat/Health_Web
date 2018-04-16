<?php

namespace HealthAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SubBodyParts
 *
 * @ORM\Table(name="sub_body_parts", indexes={@ORM\Index(name="ID_BODY_PART", columns={"ID_BODY_PART"})})
 * @ORM\Entity
 */
class SubBodyParts
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_SUB_BODY", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSubBody;

    /**
     * @var string
     *
     * @ORM\Column(name="NOM_SUB_BODY", type="string", length=255, nullable=false)
     */
    private $nomSubBody;

    /**
     * @var \BodyParts
     *
     * @ORM\ManyToOne(targetEntity="BodyParts")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_BODY_PART", referencedColumnName="ID_BODY_PART")
     * })
     */
    private $idBodyPart;

    /**
     * @return int
     */
    public function getIdSubBody()
    {
        return $this->idSubBody;
    }

    /**
     * @param int $idSubBody
     */
    public function setIdSubBody($idSubBody)
    {
        $this->idSubBody = $idSubBody;
    }

    /**
     * @return string
     */
    public function getNomSubBody()
    {
        return $this->nomSubBody;
    }

    /**
     * @param string $nomSubBody
     */
    public function setNomSubBody($nomSubBody)
    {
        $this->nomSubBody = $nomSubBody;
    }

    /**
     * @return \BodyParts
     */
    public function getIdBodyPart()
    {
        return $this->idBodyPart;
    }

    /**
     * @param \BodyParts $idBodyPart
     */
    public function setIdBodyPart($idBodyPart)
    {
        $this->idBodyPart = $idBodyPart;
    }


}

