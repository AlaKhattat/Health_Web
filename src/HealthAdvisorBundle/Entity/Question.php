<?php

namespace HealthAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;




/**
 * Question
 *
 * @ORM\Table(name="question", indexes={@ORM\Index(name="fk_QUESTION_PATIENT", columns={"ID_PATIENT"})})
 * @ORM\Entity(repositoryClass="HealthAdvisorBundle\Repository\QuestionRepository")
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
     * Set question
     *
     * @param string $question
     *
     * @return Question
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    
        return $this;
    }

    /**
     * Get question
     *
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Set datePublication
     *
     * @param \DateTime $datePublication
     *
     * @return Question
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
     * @return Question
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
     * Set specialite
     *
     * @param string $specialite
     *
     * @return Question
     */
    public function setSpecialite($specialite)
    {
        $this->specialite = $specialite;
    
        return $this;
    }

    /**
     * Get specialite
     *
     * @return string
     */
    public function getSpecialite()
    {
        return $this->specialite;
    }

    /**
     * Set signalisationEtat
     *
     * @param boolean $signalisationEtat
     *
     * @return Question
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
     * Set idPatient
     *
     * @param \HealthAdvisorBundle\Entity\Patient $idPatient
     *
     * @return Question
     */
    public function setIdPatient(\HealthAdvisorBundle\Entity\Patient $idPatient = null)
    {
        $this->idPatient = $idPatient;
    
        return $this;
    }

    /**
     * Get idPatient
     *
     * @return \HealthAdvisorBundle\Entity\Patient
     */
    public function getIdPatient()
    {
        return $this->idPatient;
    }
}
