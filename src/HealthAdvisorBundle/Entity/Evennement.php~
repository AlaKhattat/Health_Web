<?php

namespace HealthAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evennement
 *
 * @ORM\Table(name="evennement")
 * @ORM\Entity
 */
class Evennement
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
     * @ORM\Column(name="NOM", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE", type="date", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="LOCATION", type="string", length=255, nullable=false)
     */
    private $location;

    /**
     * @var string
     *
     * @ORM\Column(name="TYPE", type="string", length=255, nullable=false)
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="MAX_PARTICIPANTS", type="integer", nullable=false)
     */
    private $maxParticipants;

    /**
     * @var string
     *
     * @ORM\Column(name="URL_IMAGE", type="string", length=255, nullable=false)
     */
    private $urlImage;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="HEURE", type="time", nullable=false)
     */
    private $heure;

    /**
     * @var string
     *
     * @ORM\Column(name="VALIDATION", type="string", length=255, nullable=false)
     */
    private $validation;

    /**
     * @var string
     *
     * @ORM\Column(name="CREATEUR", type="string", length=255, nullable=false)
     */
    private $createur;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Patient", inversedBy="idEvent")
     * @ORM\JoinTable(name="evennement_participants",
     *   joinColumns={
     *     @ORM\JoinColumn(name="ID_EVENT", referencedColumnName="ID")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ID_USER", referencedColumnName="LOGIN")
     *   }
     * )
     */
    private $idUser;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idUser = new \Doctrine\Common\Collections\ArrayCollection();
    }

}

