<?php

namespace HealthAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SubBodyPartsSymptome
 *
 * @ORM\Table(name="sub_body_parts_symptome", indexes={@ORM\Index(name="ID_SUB_BODY", columns={"ID_SUB_BODY"}), @ORM\Index(name="FK_SYMPTOME", columns={"ID_SYMPTOME"})})
 * @ORM\Entity
 */
class SubBodyPartsSymptome
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_sub_body_parts_symptome", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idSubBodyPartsSymptome;

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", length=255, nullable=false)
     */
    private $gender;

    /**
     * @var \SubBodyParts
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="SubBodyParts")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_SUB_BODY", referencedColumnName="ID_SUB_BODY")
     * })
     */
    private $idSubBody;

    /**
     * @var \Symptome
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Symptome")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_SYMPTOME", referencedColumnName="ID_SYMPTOME")
     * })
     */
    private $idSymptome;


}

