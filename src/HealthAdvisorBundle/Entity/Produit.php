<?php

namespace HealthAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="produit", uniqueConstraints={@ORM\UniqueConstraint(name="REFERENCE", columns={"REFERENCE"})})
 * @ORM\Entity
 */
class Produit
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_PRODUIT", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idProduit;

    /**
     * @var string
     *
     * @ORM\Column(name="REFERENCE", type="string", length=255, nullable=false)
     */
    private $reference;

    /**
     * @var string
     *
     * @ORM\Column(name="NOM", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var float
     *
     * @ORM\Column(name="PRIX_VENTE", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixVente;

    /**
     * @var string
     *
     * @ORM\Column(name="URL_IMAGE", type="string", length=255, nullable=false)
     */
    private $urlImage;

    /**
     * @var string
     *
     * @ORM\Column(name="DESCRIPTION", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="TYPE", type="string", length=255, nullable=false)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATE_MISE", type="date", nullable=false)
     */
    private $dateMise;

    /**
     * @var float
     *
     * @ORM\Column(name="PROMOTION", type="float", precision=10, scale=0, nullable=false)
     */
    private $promotion = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="ID_USER", type="string", length=255, nullable=false)
     */
    private $idUser;

    /**
     * @var integer
     *
     * @ORM\Column(name="QUANTITE", type="integer", nullable=false)
     */
    private $quantite;

    /**
     * @var integer
     *
     * @ORM\Column(name="SIGNALISATION_ETAT", type="integer", nullable=false)
     */
    private $signalisationEtat;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Commande", inversedBy="idProduit")
     * @ORM\JoinTable(name="ligne_commande",
     *   joinColumns={
     *     @ORM\JoinColumn(name="ID_PRODUIT", referencedColumnName="ID_PRODUIT")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ID_COMMANDE", referencedColumnName="NUMERO_COMMANDE")
     *   }
     * )
     */
    private $idCommande;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idCommande = new \Doctrine\Common\Collections\ArrayCollection();
    }

}

