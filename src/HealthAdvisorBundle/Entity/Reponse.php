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



    /**
     * Get idReponse
     *
     * @return integer
     */
    public function getIdReponse()
    {
        return $this->idReponse;
    }

    /**
     * Set reponse
     *
     * @param string $reponse
     *
     * @return Reponse
     */
    public function setReponse($reponse)
    {
        $this->reponse = $reponse;
    
        return $this;
    }

    /**
     * Get reponse
     *
     * @return string
     */
    public function getReponse()
    {
        return $this->reponse;
    }

    /**
     * Set datePublication
     *
     * @param \DateTime $datePublication
     *
     * @return Reponse
     */
    public function setDatePublication($datePublication)
    {
        $this->datePublication = $datePublication;
    
        return $this;
    }

    /**
     * Get datePublication
     *
     * @return \DateTime
     */
    public function getDatePublication()
    {
        return $this->datePublication;
    }

    /**
     * Set modificationEtat
     *
     * @param boolean $modificationEtat
     *
     * @return Reponse
     */
    public function setModificationEtat($modificationEtat)
    {
        $this->modificationEtat = $modificationEtat;
    
        return $this;
    }

    /**
     * Get modificationEtat
     *
     * @return boolean
     */
    public function getModificationEtat()
    {
        return $this->modificationEtat;
    }

    /**
     * Set signalisationEtat
     *
     * @param boolean $signalisationEtat
     *
     * @return Reponse
     */
    public function setSignalisationEtat($signalisationEtat)
    {
        $this->signalisationEtat = $signalisationEtat;
    
        return $this;
    }

    /**
     * Get signalisationEtat
     *
     * @return boolean
     */
    public function getSignalisationEtat()
    {
        return $this->signalisationEtat;
    }

    /**
     * Set idMedecin
     *
     * @param \HealthAdvisorBundle\Entity\Medecin $idMedecin
     *
     * @return Reponse
     */
    public function setIdMedecin(\HealthAdvisorBundle\Entity\Medecin $idMedecin = null)
    {
        $this->idMedecin = $idMedecin;
    
        return $this;
    }

    /**
     * Get idMedecin
     *
     * @return \HealthAdvisorBundle\Entity\Medecin
     */
    public function getIdMedecin()
    {
        return $this->idMedecin;
    }

    /**
     * Set idQuestion
     *
     * @param \HealthAdvisorBundle\Entity\Question $idQuestion
     *
     * @return Reponse
     */
    public function setIdQuestion(\HealthAdvisorBundle\Entity\Question $idQuestion = null)
    {
        $this->idQuestion = $idQuestion;
    
        return $this;
    }

    /**
     * Get idQuestion
     *
     * @return \HealthAdvisorBundle\Entity\Question
     */
    public function getIdQuestion()
    {
        return $this->idQuestion;
    }
}
