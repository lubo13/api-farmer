<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Validator\Constraints\AssetRentPercent;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read", "read:contract", "read:contract-rent", "enable_max_depth"=true}},
 *     denormalizationContext={"groups"={"write:contract", "write:contract-rent"}},
 *     attributes={"security"="is_granted('ROLE_USER')"},
 *     collectionOperations={
 *         "get"={"security"="is_granted('ROLE_USER')"},
 *         "post"={"security"="is_granted('ROLE_USER')"}
 *     },
 *     itemOperations={
 *         "get"={"security"="is_granted('ROLE_USER') and object.getUser() == user"},
 *         "patch"={"security"="is_granted('ROLE_USER') and object.getUser() == user"},
 *         "delete"={"security"="is_granted('ROLE_USER') and object.getUser() == user"},
 *         "put"={"security"="is_granted('ROLE_USER') and object.getUser() == user"},
 *     }
 * )
 * )
 * @ORM\Entity(repositoryClass="App\Repository\ContractRentRepository")
 * @AssetRentPercent
 */
class ContractRent extends Contract
{
    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     * @Assert\NotBlank
     * @Assert\Range(min=0, minMessage="The price must be superior to 0.")
     * @Groups({"read:contract", "read:contract-rent", "write:contract", "write:contract-rent", "read:asset"})
     */
    private $rentPerDecare;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ContractRentAsset", mappedBy="contractRent", cascade={"persist", "remove"})
     * @Groups({"read:contract", "read:contract-rent", "write:contract", "write:contract-rent"})
     */
    private $contractRentAssets;

    public function __construct()
    {
        $this->contractRentAssets = new ArrayCollection();
    }

    public function getRentPerDecare(): ?string
    {
        return $this->rentPerDecare;
    }

    public function setRentPerDecare(string $rentPerDecare): self
    {
        $this->rentPerDecare = $rentPerDecare;

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
            $contractRentAsset->setContractRent($this);
        }

        return $this;
    }

    public function removeContractRentAsset(ContractRentAsset $contractRentAsset): self
    {
        if ($this->contractRentAssets->contains($contractRentAsset)) {
            $this->contractRentAssets->removeElement($contractRentAsset);
            // set the owning side to null (unless already changed)
            if ($contractRentAsset->getContractRent() === $this) {
                $contractRentAsset->setContractRent(null);
            }
        }

        return $this;
    }


}
