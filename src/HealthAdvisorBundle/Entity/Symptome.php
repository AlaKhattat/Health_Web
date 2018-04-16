<?php

namespace HealthAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Symptome
 *
 * @ORM\Table(name="symptome")
 * @ORM\Entity
 */
class Symptome
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_SYMPTOME", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSymptome;

    /**
     * @var string
     *
     * @ORM\Column(name="NOM_SYMPTOME", type="string", length=255, nullable=false)
     */
    private $nomSymptome;

    /**
     * @var string
     *
     * @ORM\Column(name="DESCRIPTION", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @return int
     */
    public function getIdSymptome()
    {
        return $this->idSymptome;
    }

    /**
     * @param int $idSymptome
     */
    public function setIdSymptome($idSymptome)
    {
        $this->idSymptome = $idSymptome;
    }

    /**
     * @return string
     */
    public function getNomSymptome()
    {
        return $this->nomSymptome;
    }

    /**
     * @param string $nomSymptome
     */
    public function setNomSymptome($nomSymptome)
    {
        $this->nomSymptome = $nomSymptome;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }


}

