<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commentaire
 *
 * @ORM\Table(name="commentaire")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\CommentaireRepository")
 */
class Commentaire
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *@ORM\ManyToOne (targetEntity="UserBundle\Entity\User")
     *@ORM\JoinColumn(name="id_user", referencedColumnName="id")
     */
    private $idUser;

    /**
     *@ORM\ManyToOne (targetEntity="UserBundle\Entity\Evenement", inversedBy="commentaire")
     *@ORM\JoinColumn(name="id_evenement", referencedColumnName="id")
     */
    private $idEvenement;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_commentaire", type="date")
     */
    private $dateCommentaire;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="string", length=255)
     */
    private $contenu;

    /**
     * @var string
     *
     * @ORM\Column(name="Etat_Commentaire", type="string", length=255, nullable=true)
     */
    private $etatCommentaire;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idUser
     *
     * @param integer $idUser
     *
     * @return Commentaire
     */
    public function setIdUser(\UserBundle\Entity\User $idUser = null)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return int
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set idEvenement
     *
     * @param integer $idEvenement
     *
     * @return Commentaire
     */
    public function setIdEvenement($idEvenement)
    {
        $this->idEvenement = $idEvenement;

        return $this;
    }

    /**
     * Get idEvenement
     *
     * @return int
     */
    public function getIdEvenement()
    {
        return $this->idEvenement;
    }

    public function __construct()
    {
        $this->dateCommentaire = new \DateTime();
    }

    /**
     * Set dateCommentaire
     *
     * @param \DateTime $dateCommentaire
     *
     * @return Commentaire
     */
    public function setDateCommentaire($dateCommentaire)
    {
        $this->dateCommentaire = $dateCommentaire;

        return $this;
    }

    /**
     * Get dateCommentaire
     *
     * @return \DateTime
     */
    public function getDateCommentaire()
    {
        return $this->dateCommentaire;
    }

    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Commentaire
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
     * Set etatCommentaire
     *
     * @param string $etatCommentaire
     *
     * @return Commentaire
     */
    public function setEtatCommentaire($etatCommentaire)
    {
        $this->etatCommentaire = $etatCommentaire;

        return $this;
    }

    /**
     * Get etatCommentaire
     *
     * @return string
     */
    public function getEtatCommentaire()
    {
        return $this->etatCommentaire;
    }
}
