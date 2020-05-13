<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints\AssetRentPercent;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use ApiPlatform\Core\Annotation\ApiProperty;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContractRentAssetRepository")
 * @AssetRentPercent
 */
class ContractRentAsset
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Asset", inversedBy="contractRentAssets", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     * @Assert\NotBlank
     * @Assert\Valid
     * @MaxDepth(5)
     * @Groups({"read:contract", "read:contract-rent", "write:contract", "write:contract-rent", "read:asset"})
     */
    private $asset;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ContractRent", inversedBy="contractRentAssets", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     * @Assert\NotBlank
     * @Assert\Valid
     * @MaxDepth(2)
     */
    private $contractRent;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank
     * @Groups({"read:contract", "read:contract-rent", "write:contract", "write:contract-rent", "read:asset"})
     */
    private $assetRentPercent;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Landlord", inversedBy="contractRentAssets", cascade={"persist", "remove"})
     * @Assert\NotBlank
     * @Assert\Valid
     * @Groups({"read:contract", "read:contract-rent", "write:contract", "write:contract-rent", "read:asset"})
     */
    private $landlord;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAsset(): ?Asset
    {
        return $this->asset;
    }

    public function setAsset(?Asset $asset): self
    {
        $this->asset = $asset;

        return $this;
    }

    public function getContractRent(): ?ContractRent
    {
        return $this->contractRent;
    }

    public function setContractRent(?ContractRent $contractRent): self
    {
        $this->contractRent = $contractRent;

        return $this;
    }

    public function getAssetRentPercent(): ?int
    {
        return $this->assetRentPercent;
    }

    public function setAssetRentPercent(int $assetRentPercent): self
    {
        $this->assetRentPercent = $assetRentPercent;

        return $this;
    }

    public function getLandlord(): ?Landlord
    {
        return $this->landlord;
    }

    public function setLandlord(?Landlord $landlord): self
    {
        $this->landlord = $landlord;

        return $this;
    }
}
