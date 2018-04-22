<?php

namespace HealthAdvisorBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ArticleNote
 *
 * @ORM\Table(name="Article_note", indexes={@ORM\Index(name="IDX_EA520265F8371B55", columns={"ID_USER"}), @ORM\Index(name="FK_EA5202652E4ED87F", columns={"ID_ARTICLE"})})
 * @ORM\Entity
 */
class ArticleNote
{

    /**
     * @var float
     *
     * @ORM\Column(name="VOTE", type="float", precision=10, scale=0, nullable=false)
     */
    private $vote;

    /**
     * @var \Article
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Article")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_ARTICLE", referencedColumnName="REFERENCE")
     * })
     */
    private $idArticle;

    /**
     * @var \Patient
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Patient")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_USER", referencedColumnName="LOGIN")
     * })
     */
    private $idUser;

    /**
     * Set vote
     *
     * @param float $vote
     *
     * @return ArticleNote
     */
    public function setVote($vote)
    {
        $this->vote = $vote;

        return $this;
    }

    /**
     * Get vote
     *
     * @return float
     */
    public function getVote()
    {
        return $this->vote;
    }

    /**
     * Set idArticle
     *
     * @param \HealthAdvisorBundle\Entity\Article $idArticle
     *
     * @return ArticleNote
     */
    public function setIdArticle(\HealthAdvisorBundle\Entity\Article $idArticle)
    {
        $this->idArticle = $idArticle;

        return $this;
    }

    /**
     * Get idArticle
     *
     * @return \HealthAdvisorBundle\Entity\Article
     */
    public function getIdArticle()
    {
        return $this->idArticle;
    }

    /**
     * Set idUser
     *
     * @param \HealthAdvisorBundle\Entity\Patient $idUser
     *
     * @return ArticleNote
     */
    public function setIdUser(\HealthAdvisorBundle\Entity\Patient $idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return \HealthAdvisorBundle\Entity\Patient
     */
    public function getIdUser()
    {
        return $this->idUser;
    }
}
