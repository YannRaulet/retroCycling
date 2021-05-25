<?php

namespace App\Entity;

use App\Repository\CyclingShirtRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use DateTime;

/**
 * @ORM\Entity(repositoryClass=CyclingShirtRepository::class)
 * @Vich\Uploadable
 */
class CyclingShirt
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $pictureFront = "";

    /**
     * @Vich\UploadableField(mapping="cycling_shirt_picture_front", fileNameProperty="pictureFront")
     */
    private ?File $shirtPictureFront = null;

     /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $pictureBack = "";

    /**
     * @Vich\UploadableField(mapping="cycling_shirt_picture_back", fileNameProperty="pictureBack")
     */
    private ?File $shirtPictureBack = null;


    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private DateTime $updatedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $cyclistName;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $teamInformations;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $results;

    /**
     * @ORM\OneToMany(targetEntity=Favorite::class, mappedBy="cyclingShirt")
     */
    private collection $favorites;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $years;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="likes")
     */
    private collection $userLikes;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="favorites")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?User $owner;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $city;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $latitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private ?float $longitude;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $departmentName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $departmentNumber;

    public function __construct()
    {
        $this->favorites = new ArrayCollection();
        $this->userLikes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPictureFront(): ?string
    {
        return $this->pictureFront;
    }

    public function setPictureFront(?string $pictureFront): self
    {
        $this->pictureFront = $pictureFront;

        return $this;
    }

    public function getShirtPictureFront(): ?File
    {
        return $this->shirtPictureFront;
    }

    public function setShirtPictureFront(File $shirtPictureFront = null): self
    {
        $this->shirtPictureFront = $shirtPictureFront;
        if ($shirtPictureFront) {
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }

    public function getPictureBack(): ?string
    {
        return $this->pictureBack;
    }

    public function setPictureBack(?string $pictureBack): self
    {
        $this->pictureBack = $pictureBack;

        return $this;
    }

    public function getShirtPictureBack(): ?File
    {
        return $this->shirtPictureBack;
    }

    public function setShirtPictureBack(File $shirtPictureBack = null): self
    {
        $this->shirtPictureBack = $shirtPictureBack;
        if ($shirtPictureBack) {
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCyclistName(): ?string
    {
        return $this->cyclistName;
    }

    public function setCyclistName(?string $cyclistName): self
    {
        $this->cyclistName = $cyclistName;

        return $this;
    }

    public function getTeamInformations(): ?string
    {
        return $this->teamInformations;
    }

    public function setTeamInformations(?string $teamInformations): self
    {
        $this->teamInformations = $teamInformations;

        return $this;
    }

    public function getResults(): ?string
    {
        return $this->results;
    }

    public function setResults(?string $results): self
    {
        $this->results = $results;

        return $this;
    }

    /**
     * @return Collection|Favorite[]
     */
    public function getFavorites(): Collection
    {
        return $this->favorites;
    }

    public function addFavorite(Favorite $favorite): self
    {
        if (!$this->favorites->contains($favorite)) {
            $this->favorites[] = $favorite;
            $favorite->setCyclingShirt($this);
        }

        return $this;
    }

    public function removeFavorite(Favorite $favorite): self
    {
        if ($this->favorites->removeElement($favorite)) {
            // set the owning side to null (unless already changed)
            if ($favorite->getCyclingShirt() === $this) {
                $favorite->setCyclingShirt(null);
            }
        }

        return $this;
    }

    public function getYears(): ?string
    {
        return $this->years;
    }

    public function setYears(string $years): self
    {
        $this->years = $years;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUserLikes(): Collection
    {
        return $this->userLikes;
    }

    public function addUserLike(User $userLike): self
    {
        if (!$this->userLikes->contains($userLike)) {
            $this->userLikes[] = $userLike;
            $userLike->addLike($this);
        }

        return $this;
    }

    public function removeUserLike(User $userLike): self
    {
        if ($this->userLikes->removeElement($userLike)) {
            $userLike->removeLike($this);
        }

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getDepartmentName(): ?string
    {
        return $this->departmentName;
    }

    public function setDepartmentName(?string $departmentName): self
    {
        $this->departmentName = $departmentName;

        return $this;
    }

    public function getDepartmentNumber(): ?int
    {
        return $this->departmentNumber;
    }

    public function setDepartmentNumber(?int $departmentNumber): self
    {
        $this->departmentNumber = $departmentNumber;

        return $this;
    }
}
