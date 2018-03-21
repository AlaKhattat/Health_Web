<?php

namespace HealthAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande", uniqueConstraints={@ORM\UniqueConstraint(name="REFERENCE_COMMANDE", columns={"REFERENCE_COMMANDE"})}, indexes={@ORM\Index(name="fk_COMMANDE_CLIENT", columns={"ID_CLIENT"})})
 * @ORM\Entity
 */
class Commande
{
    /**
     * @var integer
     *
     * @ORM\Column(name="NUMERO_COMMANDE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $numeroCommande;

    /**
     * @var string
     *
     * @ORM\Column(name="REFERENCE_COMMANDE", type="string", length=255, nullable=false)
     */
    private $referenceCommande;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_PAYEMENT", type="date", nullable=false)
     */
    private $datePayement;

    /**
     * @var string
     *
     * @ORM\Column(name="MODE_PAYEMENT", type="string", length=255, nullable=false)
     */
    private $modePayement;

    /**
     * @var string
     *
     * @ORM\Column(name="ID_CLIENT", type="string", length=255, nullable=false)
     */
    private $idClient;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Produit", mappedBy="idCommande")
     */
    private $idProduit;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idProduit = new \Doctrine\Common\Collections\ArrayCollection();
    }

}

