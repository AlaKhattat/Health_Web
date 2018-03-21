<?php

namespace HealthAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RendezVous
 *
 * @ORM\Table(name="rendez_vous", indexes={@ORM\Index(name="fk_PATIENT_RENDEZVOUS", columns={"USER_ID"}), @ORM\Index(name="fk_medecin_rendezvous", columns={"MED_ID"})})
 * @ORM\Entity
 */
class RendezVous
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
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_HEURE", type="datetime", nullable=false)
     */
    private $dateHeure;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date_Valid", type="datetime", nullable=false)
     */
    private $dateValid = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     *
     * @ORM\Column(name="STATUT", type="string", length=255, nullable=false)
     */
    private $statut;

    /**
     * @var \Medecin
     *
     * @ORM\ManyToOne(targetEntity="Medecin")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="MED_ID", referencedColumnName="LOGIN")
     * })
     */
    private $med;

    /**
     * @var \Patient
     *
     * @ORM\ManyToOne(targetEntity="Patient")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="USER_ID", referencedColumnName="LOGIN")
     * })
     */
    private $user;


}

