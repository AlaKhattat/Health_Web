<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 12/04/2018
 * Time: 00:05
 */

namespace HealthAdvisorBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Conseillesante
 *
 * @ORM\Table(name="conseillesante")
 * @ORM\Entity
 */
class Conseillesante
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idConseille", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idconseille;

    /**
     * @var string
     *
     * @ORM\Column(name="conseille", type="text", length=65535, nullable=false)
     */
    private $conseille;

    /**
     * @return int
     */
    public function getIdconseille()
    {
        return $this->idconseille;
    }

    /**
     * @param int $idconseille
     */
    public function setIdconseille($idconseille)
    {
        $this->idconseille = $idconseille;
    }

    /**
     * @return string
     */
    public function getConseille()
    {
        return $this->conseille;
    }

    /**
     * @param string $conseille
     */
    public function setConseille($conseille)
    {
        $this->conseille = $conseille;
    }


}

