<?php

namespace ArticleBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Annonce
 *
 * @ORM\Table(name="annonce")
 * @ORM\Entity(repositoryClass="ArticleBundle\Repository\AnnonceRepository")
 */
class Annonce
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
     * @var string
     *
     * @ORM\Column(name="Nom_Article", type="string", length=255)
     * @Assert\Length(
     *      min = 3,
     *      max = 50,
     *      minMessage = "le nom de l'article doit comporter au moins 3 caractères",
     *      maxMessage = "le nom de l'article ne doit pas dépasser les {{limit}} 50 caractères"
     *
     * )
     * @Assert\NotNull(message="Le nom del'evenement doit etre non null ")
     *
     */
    private $nomArticle;

    /**
     * @var string
     *
     * @ORM\Column(name="Description", type="string", length=255)
     * @Assert\NotNull(message="Description doit etre non null ")
     *
     *@Assert\Type(
     *     type="string"
     *
     * )
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="photo", type="string", length=255)
     * @Assert\NotNull(message="Il faut choisir une image  ")
     *
     */
    private $photo;
    /**
     * @Assert\File(maxSize="500k")
     */

    private $file;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="Date", type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="ArticleBundle\Entity\Categorie")
     * @ORM\JoinColumn(name="categorie_id",referencedColumnName="id")
     */
    private $categorie;


    /**
     * @var int
     *
     * @ORM\Column(name="rating", type="integer")
     */
    private $rating;

    /**
     * @return int
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param int $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }


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
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * Set nomArticle
     *
     * @param string $nomArticle
     *
     * @return Annonce
     */
    public function setNomArticle($nomArticle)
    {
        $this->nomArticle = $nomArticle;

        return $this;
    }

    /**
     * Get nomArticle
     *
     * @return string
     */
    public function getNomArticle()
    {
        return $this->nomArticle;
    }

    public function getWebPath (){
        return null === $this->photo ? null : $this->getUploadDir().'/'.$this->photo;
    }
    protected function getUploadRootDir (){
        return __DIR__.'/PIDEV/web/images/'.$this->getUploadDir();
    }
    protected function getUploadDir () {
        return 'PIDEV/web/images';
    }
    public function uploadProfilePicture()
    {
        if (null === $this->file){
            return ;
        }
        if ($this->id){
            $this->file->move($this->getUploadRootDir(), $this->file->getClientOroginalName());
        }else{
            $this->file->move($this->getUploadRootDir(),$this->file->getClientOroginalName());
        }

        $this->setPhoto($this->file->getOroginalName());
    }


    /**
     * Set description
     *
     * @param string $description
     *
     * @return Annonce
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
     * Set photo
     *
     * @param string $photo
     *
     * @return Annonce
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Annonce
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set categorie
     *
     * @param \ArticleBundle\Entity\Categorie $categorie
     *
     * @return Annonce
     */
    public function setCategorie(\ArticleBundle\Entity\Categorie $categorie = null)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \ArticleBundle\Entity\Categorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }
}
