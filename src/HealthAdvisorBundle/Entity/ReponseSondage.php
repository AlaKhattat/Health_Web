<?php

namespace HealthAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ReponseSondage
 *
 * @ORM\Table(name="reponse_sondage")
 * @ORM\Entity(repositoryClass="HealthAdvisorBundle\Repository\ReponseSondageRepository")
 */
class ReponseSondage
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \Patient
     *
     * @ORM\ManyToOne(targetEntity="HealthAdvisorBundle\Entity\Patient")
     * @ORM\JoinColumns({@ORM\JoinColumn(name="id_user", referencedColumnName="LOGIN", nullable=false)})
     */
    private $idUser;

    /**
     * @var \Sondage
     *
     * @ORM\ManyToOne(targetEntity="HealthAdvisorBundle\Entity\Sondage")
     * @ORM\JoinColumns({@ORM\JoinColumn(name="id_sondage", referencedColumnName="ID_SONDAGE", nullable=false)})
     */
    private $sondage;

    /**
     * @var string
     *
     * @ORM\Column(name="reponse", type="string", length=255)
     */
    private $reponse;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \Patient
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param \Patient $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @return \Sondage
     */
    public function getSondage()
    {
        return $this->sondage;
    }

    /**
     * @param \Sondage $sondage
     */
    public function setSondage($sondage)
    {
        $this->sondage = $sondage;
    }

    /**
     * @return string
     */
    public function getReponse()
    {
        return $this->reponse;
    }

    /**
     * @param string $reponse
     */
    public function setReponse($reponse)
    {
        $this->reponse = $reponse;
    }




}

