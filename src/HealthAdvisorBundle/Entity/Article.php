<?php

namespace HealthAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="article", indexes={@ORM\Index(name="fk_ARTICLE_MEDECIN", columns={"ID_MEDECIN"})})
 * @ORM\Entity
 */
class Article
{
    /**
     * @var integer
     *
     * @ORM\Column(name="REFERENCE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $reference;

    /**
     * @var string
     *
     * @ORM\Column(name="NOM", type="string", length=255, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="DESCRIPTION", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="CONTENU", type="string", length=255, nullable=false)
     */
    private $contenu;

    /**
     * @var string
     *
     * @ORM\Column(name="URL_IMAGE", type="string", length=255, nullable=false)
     */
    private $urlImage;

    /**
     * @var float
     *
     * @ORM\Column(name="MOYENNE_NOTES", type="float", precision=10, scale=0, nullable=false)
     */
    private $moyenneNotes;

    /**
     * @var string
     *
     * @ORM\Column(name="VALIDATION", type="string", length=255, nullable=false)
     */
    private $validation;

    /**
     * @var string
     *
     * @ORM\Column(name="TAGS", type="string", length=255, nullable=false)
     */
    private $tags;

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
     * Constructor
     */
    public function __construct()
    {
        $this->idUser = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get reference
     *
     * @return integer
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Article
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    
        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Article
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Article
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
    
        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set urlImage
     *
     * @param string $urlImage
     *
     * @return Article
     */
    public function setUrlImage($urlImage)
    {
        $this->urlImage = $urlImage;
    
        return $this;
    }

    /**
     * Get urlImage
     *
     * @return string
     */
    public function getUrlImage()
    {
        return $this->urlImage;
    }

    /**
     * Set moyenneNotes
     *
     * @param float $moyenneNotes
     *
     * @return Article
     */
    public function setMoyenneNotes($moyenneNotes)
    {
        $this->moyenneNotes = $moyenneNotes;
    
        return $this;
    }

    /**
     * Get moyenneNotes
     *
     * @return float
     */
    public function getMoyenneNotes()
    {
        return $this->moyenneNotes;
    }

    /**
     * Set validation
     *
     * @param string $validation
     *
     * @return Article
     */
    public function setValidation($validation)
    {
        $this->validation = $validation;
    
        return $this;
    }

    /**
     * Get validation
     *
     * @return string
     */
    public function getValidation()
    {
        return $this->validation;
    }

    /**
     * Set tags
     *
     * @param string $tags
     *
     * @return Article
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    
        return $this;
    }

    /**
     * Get tags
     *
     * @return string
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @return \Medecin
     */
    public function getIdMedecin()
    {
        return $this->idMedecin;
    }

    /**
     * @param \Medecin $idMedecin
     */
    public function setIdMedecin($idMedecin)
    {
        $this->idMedecin = $idMedecin;
    }



}
