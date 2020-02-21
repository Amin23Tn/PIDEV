<?php

namespace ArticleBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Statistique
 *
 * @ORM\Table(name="statistique")
 * @ORM\Entity(repositoryClass="ArticleBundle\Repository\StatistiqueRepository")
 */
class Statistique
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
     * @var int
     *
     * @ORM\Column(name="Nb_annonce", type="integer")
     */
    private $nbAnnonce;

    /**
     * @var string
     *
     * @ORM\Column(name="Categorie", type="string", length=255)
     */
    private $categorie;


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
     * Set nbAnnonce
     *
     * @param integer $nbAnnonce
     *
     * @return Statistique
     */
    public function setNbAnnonce($nbAnnonce)
    {
        $this->nbAnnonce = $nbAnnonce;

        return $this;
    }

    /**
     * Get nbAnnonce
     *
     * @return int
     */
    public function getNbAnnonce()
    {
        return $this->nbAnnonce;
    }

    /**
     * Set categorie
     *
     * @param string $categorie
     *
     * @return Statistique
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return string
     */
    public function getCategorie()
    {
        return $this->categorie;
    }
}

