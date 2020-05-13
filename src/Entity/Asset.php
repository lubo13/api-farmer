<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\MaxDepth;


/**
 * @ApiResource(
 *     description="API points for Asset",
 *     normalizationContext={"groups"={"read", "read:asset"}, "enable_max_depth"=true},
 *     denormalizationContext={"groups"={"write:asset"}},
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
 * @ORM\Entity(repositoryClass="App\Repository\AssetRepository")
 * @ORM\Table(
 *     name="assets",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="search_identification_number_idx", columns={"identification_number"})}
 *     )
 * @UniqueEntity("identificationNumber")
 */
class Asset implements CustomUserInterface
{
    use TimestampableTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @ApiProperty(iri="https://schema.org/identifier", identifier=true)
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Groups({"read:asset", "write:asset", "read:contract-asset", "write:contract-asset"})
     */
    private $areaInDecares;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups({"read:asset", "write:asset", "read:contract-asset", "write:contract-asset"})
     */
    private $identificationNumber;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\ContractAsset", mappedBy="assets", cascade={"persist", "remove"})
     * @Groups({"read:asset"})
     * @MaxDepth(1)
     */
    private $contractAssets;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ContractRentAsset", mappedBy="asset", cascade={"persist", "remove"})
     * @Groups({"read:asset"})
     * @MaxDepth(1)
     */
    private $contractRentAssets;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="assets", cascade={"persist", "remove"})
     */
    private $user;

    public function __construct()
    {
        $this->contractAssets     = new ArrayCollection();
        $this->contractRentAssets = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->identificationNumber ?? '';
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAreaInDecares(): ?int
    {
        return $this->areaInDecares;
    }

    public function setAreaInDecares(int $areaInDecares): self
    {
        $this->areaInDecares = $areaInDecares;

        return $this;
    }

    public function getIdentificationNumber(): ?string
    {
        return $this->identificationNumber;
    }

    public function setIdentificationNumber(string $identificationNumber): self
    {
        $this->identificationNumber = $identificationNumber;

        return $this;
    }

    /**
     * @return Collection|ContractAsset[]
     */
    public function getContractAssets(): Collection
    {
        return $this->contractAssets;
    }

    public function addContractAsset(ContractAsset $contractAsset): self
    {
        if (!$this->contractAssets->contains($contractAsset)) {
            $this->contractAssets[] = $contractAsset;
            $contractAsset->addAsset($this);
        }

        return $this;
    }

    public function removeContractAsset(ContractAsset $contractAsset): self
    {
        if ($this->contractAssets->contains($contractAsset)) {
            $this->contractAssets->removeElement($contractAsset);
            $contractAsset->removeAsset($this);
        }

        return $this;
    }

    /**
     * @return Collection|ContractRentAsset[]
     */
    public function getContractRentAssets(): Collection
    {
        return $this->contractRentAssets;
    }

    public function addContractRentAsset(ContractRentAsset $contractRentAsset): self
    {
        if (!$this->contractRentAssets->contains($contractRentAsset)) {
            $this->contractRentAssets[] = $contractRentAsset;
            $contractRentAsset->setAsset($this);
        }

        return $this;
    }

    public function removeContractRentAsset(ContractRentAsset $contractRentAsset): self
    {
        if ($this->contractRentAssets->contains($contractRentAsset)) {
            $this->contractRentAssets->removeElement($contractRentAsset);
            // set the owning side to null (unless already changed)
            if ($contractRentAsset->getAsset() === $this) {
                $contractRentAsset->setAsset(null);
            }
        }

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
}
