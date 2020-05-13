<?php
/**
 * @package App
 * @author  Lubo Grozdanov <grozdanov.lubo@gmail.com>
 */

namespace App\Validator\Constraints;

use App\Entity\ContractRent;
use App\Entity\ContractRentAsset;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class AssetRentPercentValidator extends ConstraintValidator
{
    /**
     * @var \Doctrine\ORM\EntityManagerInterface
     */
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function validate($object, Constraint $constraint)
    {
        $contractRentAssetRepository = $this->entityManager->getRepository(ContractRentAsset::class);

        if ($object instanceof ContractRentAsset) {
            $contracts = $contractRentAssetRepository->findBy(['asset' => $this->getAsset()]);
            $this->check($object, $contracts, $constraint);
        }

        if ($object instanceof ContractRent) {
            foreach ($object->getContractRentAssets() as $contractRentAsset) {
                $contracts = $contractRentAssetRepository->findBy(['asset' => $contractRentAsset->getAsset()]);
                $this->check($contractRentAsset, $contracts, $constraint);
            }
        }

    }

    protected function check($contractRentAsset, $contracts, Constraint $constraint)
    {
        $sum = $contractRentAsset->getAssetRentPercent();
        foreach ($contracts as $contract) {
            if ($contract->getContractRent() && $contract->getContractRent()->getId() !== $contractRentAsset->getContractRent()->getId()) {
                $sum += $contract->getAssetRentPercent();
            }
        }

        if ($sum > 100) {
            $this->context->buildViolation($constraint->message, ['%sum%' => $sum . "%"])
                ->atPath('assetRentPercent')
                ->addViolation();
        }
    }

}
