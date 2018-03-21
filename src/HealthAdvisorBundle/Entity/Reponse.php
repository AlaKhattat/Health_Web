<?php

namespace HealthAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reponse
 *
 * @ORM\Table(name="reponse", indexes={@ORM\Index(name="fk_REPONSE_MEDECIN", columns={"ID_MEDECIN"}), @ORM\Index(name="fk_REPONSE_QUESTION", columns={"ID_QUESTION"})})
 * @ORM\Entity
 */
class Reponse
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_REPONSE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idReponse;

    /**
     * @var string
     *
     * @ORM\Column(name="REPONSE", type="string", length=255, nullable=false)
     */
    private $reponse;

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
     * @var boolean
     *
     * @ORM\Column(name="SIGNALISATION_ETAT", type="boolean", nullable=true)
     */
    private $signalisationEtat;

    /**
     * @var \Medecin
     *
     * @ORM\ManyToOne(targetEntity="Medecin")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_MEDECIN", referencedColumnName="LOGIN")
     * })
     */
    private $idMedecin;

    /**
     * @var \Question
     *
     * @ORM\ManyToOne(targetEntity="Question")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_QUESTION", referencedColumnName="ID")
     * })
     */
    private $idQuestion;


}

