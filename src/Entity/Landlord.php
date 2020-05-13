<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read", "read:landlord"}},
 *     denormalizationContext={"groups"={"write:landlord"}},
 *     attributes={"security"="is_granted('ROLE_USER')"},
 *     collectionOperations={
 *         "get"={"security"="is_granted('ROLE_USER')"},
 *         "post"={"security"="is_granted('ROLE_USER')"}
 *     },
 *     itemOperations={
 *         "get"={"security"="is_granted('ROLE_USER')"},
 *         "patch"={"security"="is_granted('ROLE_USER') and object.getUser() == user"},
 *         "delete"={"security"="is_granted('ROLE_USER') and object.getUser() == user"},
 *         "put"={"security"="is_granted('ROLE_USER') and object.getUser() == user"},
 *     }
 * )
 * )
 * @ORM\Entity(repositoryClass="App\Repository\LandlordRepository")
 * @ORM\Table(
 *     name="landlord",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="search_landlord_idx", columns={"identification_number"})}
 *     )
 * @UniqueEntity("identificationNumber")
 */
class Landlord
{
    use TimestampableTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups({"read:landlord", "write:landlord"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups({"read:landlord", "write:landlord"})
     */
    private $family;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups({"read:landlord", "write:landlord"})
     */
    private $phone;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\Regex("/\d/")
     * @Groups({"read:landlord", "write:landlord"})
     */
    private $identificationNumber;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="landlords", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ContractRentAsset", mappedBy="landlord", cascade={"persist", "remove"})
     */
    private $contractRentAssets;

    public function __construct()
    {
        $this->contractRentAssets = new ArrayCollection();
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

    public function getFamily(): ?string
    {
        return $this->family;
    }

    public function setFamily(string $family): self
    {
        $this->family = $family;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getIdentificationNumber(): ?int
    {
        return $this->identificationNumber;
    }

    public function setIdentificationNumber(int $identificationNumber): self
    {
        $this->identificationNumber = $identificationNumber;

        return $this;
    }

    public function getUser(): ?UserInterface
    {
        return $this->user;
    }

    public function setUser(?UserInterface $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|ContractRentAsset[]
     */
    public function getContractRentAssets()
    {
        return $this->contractRentAssets->getValues();
    }

    public function addContractRentAsset(ContractRentAsset $contractRentAsset): self
    {
        if (!$this->contractRentAssets->contains($contractRentAsset)) {
            $this->contractRentAssets[] = $contractRentAsset;
            $contractRentAsset->setLandlord($this);
        }

        return $this;
    }

    public function removeContractRentAsset(ContractRentAsset $contractRentAsset): self
    {
        if ($this->contractRentAssets->contains($contractRentAsset)) {
            $this->contractRentAssets->removeElement($contractRentAsset);
            // set the owning side to null (unless already changed)
            if ($contractRentAsset->getLandlord() === $this) {
                $contractRentAsset->setLandlord(null);
            }
        }

        return $this;
    }
}
