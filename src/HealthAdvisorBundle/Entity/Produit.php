<?php

namespace HealthAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Produit
 *
 * @ORM\Table(name="produit", uniqueConstraints={@ORM\UniqueConstraint(name="REFERENCE", columns={"REFERENCE"})})
 * @ORM\Entity(repositoryClass="HealthAdvisorBundle\Repository\ProduitRepository")
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

    /**
     * @return int
     */
    public function getIdProduit()
    {
        return $this->idProduit;
    }

    /**
     * @param int $idProduit
     */
    public function setIdProduit($idProduit)
    {
        $this->idProduit = $idProduit;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return float
     */
    public function getPrixVente()
    {
        return $this->prixVente;
    }

    /**
     * @param float $prixVente
     */
    public function setPrixVente($prixVente)
    {
        $this->prixVente = $prixVente;
    }

    /**
     * @return string
     */
    public function getUrlImage()
    {
        return $this->urlImage;
    }

    /**
     * @param string $urlImage
     */
    public function setUrlImage($urlImage)
    {
        $this->urlImage = $urlImage;
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

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return \DateTime
     */
    public function getDateMise()
    {
        return $this->dateMise;
    }

    /**
     * @param \DateTime $dateMise
     */
    public function setDateMise($dateMise)
    {
        $this->dateMise = $dateMise;
    }

    /**
     * @return float
     */
    public function getPromotion()
    {
        return $this->promotion;
    }

    /**
     * @param float $promotion
     */
    public function setPromotion($promotion)
    {
        $this->promotion = $promotion;
    }

    /**
     * @return string
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param string $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    /**
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * @param int $quantite
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
    }

    /**
     * @return int
     */
    public function getSignalisationEtat()
    {
        return $this->signalisationEtat;
    }

    /**
     * @param int $signalisationEtat
     */
    public function setSignalisationEtat($signalisationEtat)
    {
        $this->signalisationEtat = $signalisationEtat;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIdCommande()
    {
        return $this->idCommande;
    }

    /**
     * @param \Doctrine\Common\Collections\Collection $idCommande
     */
    public function setIdCommande($idCommande)
    {
        $this->idCommande = $idCommande;
    }


}

