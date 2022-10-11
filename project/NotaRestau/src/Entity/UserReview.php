<?php

namespace App\Entity;

use App\Repository\UserReviewRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserReviewRepository::class)]
class UserReview
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $rate = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(inversedBy: 'userReviews')]
    private ?Restaurant $id_restaurant = null;

    #[ORM\ManyToOne(inversedBy: 'userReviews')]
    private ?User $user_id = null;

    #[ORM\OneToMany(mappedBy: 'user_review', targetEntity: RestorerReply::class)]
    private Collection $restorerReplies;

    public function __construct()
    {
        $this->restorerReplies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRate(): ?float
    {
        return $this->rate;
    }

    public function setRate(float $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getIdRestaurant(): ?Restaurant
    {
        return $this->id_restaurant;
    }

    public function setIdRestaurant(?Restaurant $id_restaurant): self
    {
        $this->id_restaurant = $id_restaurant;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    /**
     * @return Collection<int, RestorerReply>
     */
    public function getRestorerReplies(): Collection
    {
        return $this->restorerReplies;
    }

    public function addRestorerReply(RestorerReply $restorerReply): self
    {
        if (!$this->restorerReplies->contains($restorerReply)) {
            $this->restorerReplies->add($restorerReply);
            $restorerReply->setUserReview($this);
        }

        return $this;
    }

    public function removeRestorerReply(RestorerReply $restorerReply): self
    {
        if ($this->restorerReplies->removeElement($restorerReply)) {
            // set the owning side to null (unless already changed)
            if ($restorerReply->getUserReview() === $this) {
                $restorerReply->setUserReview(null);
            }
        }

        return $this;
    }
}
