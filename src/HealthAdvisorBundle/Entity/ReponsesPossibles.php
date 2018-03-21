<?php

namespace HealthAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReponsesPossibles
 *
 * @ORM\Table(name="reponses_possibles", indexes={@ORM\Index(name="reponses_possibles_ibfk_1", columns={"ID_SONDAGE"})})
 * @ORM\Entity
 */
class ReponsesPossibles
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
     * @var \Sondage
     *
     * @ORM\ManyToOne(targetEntity="Sondage")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_SONDAGE", referencedColumnName="ID_SONDAGE")
     * })
     */
    private $idSondage;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Patient", mappedBy="idReponse")
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

