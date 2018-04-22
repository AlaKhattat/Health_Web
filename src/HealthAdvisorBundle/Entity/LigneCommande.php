<?php

namespace HealthAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LigneCommande
 *
 * @ORM\Table(name="ligneCommande")
 * @ORM\Entity(repositoryClass="HealthAdvisorBundle\Repository\LigneCommandeRepository")
 */
class LigneCommande
{

    /**
     * @var \HealthAdvisorBundle\Entity\Produit
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="HealthAdvisorBundle\Entity\Produit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_PRODUIT", referencedColumnName="ID_PRODUIT")
     * })
     */
     private $id_produit;

    /**
     * @var \HealthAdvisorBundle\Entity\Commande
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="HealthAdvisorBundle\Entity\Commande")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_COMMANDE", referencedColumnName="NUMERO_COMMANDE")
     * })
     */
     private  $id_commande;

    /**
     * @var float
     *
     * @ORM\Column(name="PRIX", type="float", nullable=false)
     */
     private $prix;

    /**
     * @var integer
     *
     * @ORM\Column(name="QUANTITE", type="integer", nullable=false)
     */
     private $quantite;

    /**
     * @return Produit
     */
    public function getIdProduit()
    {
        return $this->id_produit;
    }

    /**
     * @param Produit $id_produit
     */
    public function setIdProduit($id_produit)
    {
        $this->id_produit = $id_produit;
    }

    /**
     * @return Commande
     */
    public function getIdCommande()
    {
        return $this->id_commande;
    }

    /**
     * @param Commande $id_commande
     */
    public function setIdCommande($id_commande)
    {
        $this->id_commande = $id_commande;
    }

    /**
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * @param float $prix
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;
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




}

