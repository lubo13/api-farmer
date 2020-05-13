<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"read", "read:contract", "read:contract-asset", "enable_max_depth"=true}},
 *     denormalizationContext={"groups"={"write:contract", "write:contract-asset"}},
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
 * @ORM\Entity(repositoryClass="App\Repository\ContractAssetRepository")
 */
class ContractAsset extends Contract
{
    /**
     * @ORM\Column(type="decimal", precision=10, scale=0)
     * @Assert\NotBlank
     * @Assert\Range(min=0, minMessage="The price must be superior to 0.")
     * @Groups({"read:contract", "read:contract-asset", "write:contract", "write:contract-asset", "read:asset"})
     */
    private $price;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Asset", inversedBy="contractAssets", cascade={"persist", "remove"})
     * @Groups({"read:contract", "read:contract-asset", "write:contract", "write:contract-asset"})
     * @MaxDepth(1)
     */
    private $assets;

    public function __construct()
    {
        $this->assets = new ArrayCollection();
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|Asset[]
     */
    public function getAssets()
    {
        return $this->assets->getValues();
    }

    public function addAsset(Asset $asset): self
    {
        if (!$this->assets->contains($asset)) {
            $this->assets[] = $asset;
        }

        return $this;
    }

    public function removeAsset(Asset $asset): self
    {
        if ($this->assets->contains($asset)) {
            $this->assets->removeElement($asset);
        }

        return $this;
    }

    public function sumDecares()
    {
        $sum = 0;

        foreach ($this->getAssets() as $asset) {
            $sum += $asset->getAreaInDecares();
        }

        return $sum;
    }

    public function decarePrice()
    {
        return number_format($this->price / $this->sumDecares(), 2);
    }
}
