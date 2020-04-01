<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookRepository")
 */
class Book {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Merci de remplir le titre")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min=20, minMessage="Le résumé doit contenir au minimum 20 caractères")
     */
    private $resume;

    /**
     * @ORM\Column(type="integer")
     * @Assert\GreaterThan(20, message="Le livre doit avoir au minimum 20 pages")
     * @Assert\LessThan(3000, message="Le livre doit avoir au maximum 3000 pages")
     */
    private $nbPages;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Author", inversedBy="books")
     */
    private $author;

    //je rajoute une colonne dans la table book qui va stocker le nom du fichier image
    /**
     * @ORM\Column(type="string")
     */
    private $cover;

    /**
     * @return mixed
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function getResume()
    {
        return $this->resume;
    }

    public function setResume($resume): void
    {
        $this->resume = $resume;
    }

    public function getNbPages()
    {
        return $this->nbPages;
    }

    public function setNbPages($nbPages)
    {
        $this->nbPages = $nbPages;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCover()
    {
        return $this->cover;
    }

    /**
     * @param mixed $cover
     */
    public function setCover($cover): void
    {
        $this->cover = $cover;
    }

}
