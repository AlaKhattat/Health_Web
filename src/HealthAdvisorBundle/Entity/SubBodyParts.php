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


}

