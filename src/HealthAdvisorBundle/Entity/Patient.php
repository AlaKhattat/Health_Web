<?php

namespace HealthAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Patient
 *
 * @ORM\Table(name="patient", indexes={@ORM\Index(name="fk_PATIENT_UTILISATEUR", columns={"CIN_USER"})})
 * @ORM\Entity
 */
class Patient
{
    /**
     * @var string
     *
     * @ORM\Column(name="LOGIN", type="string", length=255, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="PASSWORD", type="string", length=255, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="photo_profile", type="string", length=255, nullable=true)
     */
    private $photoProfile;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="CIN_USER", referencedColumnName="CIN")
     * })
     */
    private $cinUser;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Article", mappedBy="idUser")
     */
    private $idArticle;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Evennement", mappedBy="idUser")
     */
    private $idEvent;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Regime", inversedBy="idUser")
     * @ORM\JoinTable(name="regime_user",
     *   joinColumns={
     *     @ORM\JoinColumn(name="ID_USER", referencedColumnName="LOGIN")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ID_REGIME", referencedColumnName="ID_REGIME")
     *   }
     * )
     */
    private $idRegime;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="ReponsesPossibles", inversedBy="idUser")
     * @ORM\JoinTable(name="user_reponse",
     *   joinColumns={
     *     @ORM\JoinColumn(name="ID_USER", referencedColumnName="LOGIN")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ID_REPONSE", referencedColumnName="ID_REPONSE")
     *   }
     * )
     */
    private $idReponse;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idArticle = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idEvent = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idRegime = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idReponse = new \Doctrine\Common\Collections\ArrayCollection();
    }

}

