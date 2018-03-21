<?php

namespace HealthAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table(name="question", indexes={@ORM\Index(name="fk_QUESTION_PATIENT", columns={"ID_PATIENT"})})
 * @ORM\Entity
 */
class Question
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="QUESTION", type="string", length=255, nullable=false)
     */
    private $question;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_publication", type="datetime", nullable=false)
     */
    private $datePublication;

    /**
     * @var boolean
     *
     * @ORM\Column(name="modification_etat", type="boolean", nullable=false)
     */
    private $modificationEtat;

    /**
     * @var string
     *
     * @ORM\Column(name="specialite", type="string", length=255, nullable=true)
     */
    private $specialite;

    /**
     * @var boolean
     *
     * @ORM\Column(name="SIGNALISATION_ETAT", type="boolean", nullable=true)
     */
    private $signalisationEtat;

    /**
     * @var \Patient
     *
     * @ORM\ManyToOne(targetEntity="Patient")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_PATIENT", referencedColumnName="LOGIN")
     * })
     */
    private $idPatient;


}

