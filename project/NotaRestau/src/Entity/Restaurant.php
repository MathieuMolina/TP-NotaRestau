<?php

namespace App\Entity;

use App\Repository\RestaurantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RestaurantRepository::class)]
class Restaurant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $adress = null;

    #[ORM\Column(length: 255)]
    private ?string $phone_number = null;

    #[ORM\Column]
    private ?int $post_code = null;

    #[ORM\OneToMany(mappedBy: 'id_restaurant', targetEntity: UserReview::class)]
    private Collection $userReviews;

    public function __construct()
    {
        $this->userReviews = new ArrayCollection();
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

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(string $phone_number): self
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getPostCode(): ?int
    {
        return $this->post_code;
    }

    public function setPostCode(int $post_code): self
    {
        $this->post_code = $post_code;

        return $this;
    }

    /**
     * @return Collection<int, UserReview>
     */
    public function getUserReviews(): Collection
    {
        return $this->userReviews;
    }

    public function addUserReview(UserReview $userReview): self
    {
        if (!$this->userReviews->contains($userReview)) {
            $this->userReviews->add($userReview);
            $userReview->setIdRestaurant($this);
        }

        return $this;
    }

    public function removeUserReview(UserReview $userReview): self
    {
        if ($this->userReviews->removeElement($userReview)) {
            // set the owning side to null (unless already changed)
            if ($userReview->getIdRestaurant() === $this) {
                $userReview->setIdRestaurant(null);
            }
        }

        return $this;
    }
}
