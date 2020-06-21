<?php

namespace App\Entity;

use App\Repository\ActorRepository;
use App\Repository\ProgramRepository;
use App\Service\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ActorRepository::class)
 * @Vich\Uploadable
 */
class Actor
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Program::class, inversedBy="actors")
     */
    private $programs;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

     /**
     * @Vich\UploadableField(mapping="actorImg_file", fileNameProperty="image")
     * @var File
     */
    private $actorImg;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;


    public function __construct()
    {
        $this->programs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        $slug = new Slugify();
        $this->setSlug($slug->generate($name));
        return $this;
    }

    /**
     * @return Collection|Program[]
     */
    public function getPrograms(): Collection
    {
        /** @var \ArrayIterator $iterator */
        $iterator = $this->programs->getIterator();
        $iterator->uasort(function (Program $a, Program $b) {
            return strcmp($a->getTitle() ,$b->getTitle());
        });

        $values = $this->programs->toArray();
        asort($values);
        return new ArrayCollection($values);




    }

    public function addProgram(Program $program): self
    {



        if (!$this->programs->contains($program)) {
            $this->programs[] = $program;
        }

        return $this;
    }

    public function removeProgram(Program $program): self
    {
        if ($this->programs->contains($program)) {
            $this->programs->removeElement($program);
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\File\File
     */
    public function getActorImg(): ?\Symfony\Component\HttpFoundation\File\File
    {
        return $this->actorImg;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\File $actorImg
     */
    public function setActorImg(\Symfony\Component\HttpFoundation\File\File $actorImg): void
    {
        if ($actorImg) {
            $this->updatedAt = new \DateTime('now');
        }
        $this->actorImg = $actorImg;
    }


}
